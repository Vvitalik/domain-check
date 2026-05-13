let toastTimeout = null;

export function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');

    if (!toast) {
        return;
    }

    if (toastTimeout) {
        clearTimeout(toastTimeout);
    }

    toast.textContent = message;

    toast.style.display = 'block';
    toast.style.position = 'fixed';
    toast.style.top = '24px';
    toast.style.right = '24px';
    toast.style.zIndex = '9999';

    toast.className = 'rounded-xl border px-5 py-4 text-sm font-medium shadow-lg';

    if (type === 'error') {
        toast.classList.add('border-red-200', 'bg-red-50', 'text-red-700');
    } else {
        toast.classList.add('border-emerald-200', 'bg-emerald-50', 'text-emerald-700');
    }

    toastTimeout = setTimeout(() => {
        toast.style.display = 'none';
    }, 3000);
}
