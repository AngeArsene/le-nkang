<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Placeholder request that currently denies review submissions and defines no validation rules.
 */
class StoreReviewRequest extends FormRequest
{
    /**
     * Deny all review submissions.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Return the currently empty set of review validation rules.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
