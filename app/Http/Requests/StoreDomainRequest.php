<?php

namespace App\Http\Requests;

use App\Enums\DomainCheckMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDomainRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'interval_min' => ['required', 'integer', 'min:1', 'max:500'],
            'timeout_sec' => ['required', 'integer', 'min:1', 'max:30'],
            'url' => ['required', 'url', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
            'method' => ['required', Rule::enum(DomainCheckMethod::class)],
        ];
    }
}
