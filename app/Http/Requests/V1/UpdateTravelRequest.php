<?php

declare(strict_types=1);

namespace App\Http\Requests\V1;

use App\Models\Travel;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTravelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return ! is_null($this->user()) && $this->user()->can('update', Travel::class);
    }

    /**
     * @return array<string,\Illuminate\Contracts\Validation\ValidationRule|array<int,string>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string'],
            'is_public' => ['boolean'],
            'num_of_days' => ['numeric', 'min:1'],
            'description' => ['string', 'max:200'],
        ];
    }
}
