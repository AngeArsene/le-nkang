<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Placeholder request that currently denies review updates and defines no validation rules.
 */
class UpdateReviewRequest extends FormRequest
{
    /**
     * Deny all review updates.
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
