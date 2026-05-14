import { showToast } from '../toast';

function secureUrl(url) {
    const parsedUrl = new URL(url, window.location.origin);
    parsedUrl.protocol = window.location.protocol;

    return parsedUrl.toString();
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.js-delete-domain').forEach((button) => {
        button.addEventListener('click', async () => {
            if (!confirm('Delete this domain?')) {
                return;
            }

            const originalText = button.textContent;

            button.disabled = true;
            button.textContent = 'Deleting...';
            button.classList.add('opacity-60', 'cursor-not-allowed');

            try {
                const response = await fetch(secureUrl(button.dataset.deleteUrl), {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                });

                if (!response.ok) {
                    throw new Error('Delete request failed.');
                }

                const data = await response.json();

                button.closest('tr')?.remove();

                showToast(data.message || 'Domain was deleted.');
            } catch (error) {
                button.disabled = false;
                button.textContent = originalText;
                button.classList.remove('opacity-60', 'cursor-not-allowed');

                showToast('Something went wrong. Please try again.', 'error');
            }
        });
    });

    document.querySelectorAll('.js-check-domain').forEach((button) => {
        button.addEventListener('click', async () => {
            const originalText = button.textContent;

            button.disabled = true;
            button.textContent = 'Checking...';
            button.classList.add('opacity-60', 'cursor-not-allowed');

            try {
                const response = await fetch(secureUrl(button.dataset.checkUrl), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                });

                if (!response.ok) {
                    throw new Error('Check request failed.');
                }

                const data = await response.json();
                const row = button.closest('tr');

                row.querySelector('[data-status-badge]').innerHTML = renderStatusBadge(data.status);
                row.querySelector('[data-last-check]').textContent = data.last_checked_at ?? 'Just now';

                showToast(data.message || 'Domain check completed.');
            } catch (error) {
                showToast('Domain check failed. Please try again.', 'error');
            } finally {
                button.disabled = false;
                button.textContent = originalText;
                button.classList.remove('opacity-60', 'cursor-not-allowed');
            }
        });
    });

    function renderStatusBadge(status) {
        if (status === 'up') {
            return '<span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">UP</span>';
        }

        if (status === 'down') {
            return '<span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">DOWN</span>';
        }

        if (status === 'timeout') {
            return '<span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">TIMEOUT</span>';
        }

        return '<span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">UNKNOWN</span>';
    }
});

document.addEventListener('click', async (event) => {
    const domainsLink = event.target.closest('.js-domains-pagination a');

    if (domainsLink) {
        event.preventDefault();

        const url = secureUrl(domainsLink.href);

        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
        });

        const html = await response.text();

        document.getElementById('domains-table').innerHTML = html;

        window.history.pushState({}, '', url);

        return;
    }

    const checksLink = event.target.closest('.js-domain-checks-pagination a');

    if (checksLink) {
        event.preventDefault();

        const url = secureUrl(checksLink.href);

        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
        });

        const html = await response.text();

        document.getElementById('domain-checks-table').innerHTML = html;

        window.history.pushState({}, '', url);
    }
});
