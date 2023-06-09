<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Travel;
use Illuminate\Foundation\Http\FormRequest;

class StoreTravelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Travel::class);
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'is_public' => ['boolean'],
            'name' => ['string', 'max:200'],
            'slug' => ['string'],
            'num_of_days' => ['required', 'numeric', 'gt:0'],
            'description' => ['string'],
        ];
    }
}
