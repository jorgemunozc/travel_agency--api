<?php

declare(strict_types=1);

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterSortRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var \App\Models\Travel */
        $travel = $this->route('travel');

        return (is_null($this->user()) && $travel->isPublic()) || $this->user()?->can('view', $travel);
    }

    /**
     * @return array<string,\Illuminate\Contracts\Validation\ValidationRule|array<int,string|\Illuminate\Validation\ConditionalRules|\Illuminate\Validation\Rules\In>|string>
     */
    public function rules(): array
    {

        return [
            'priceFrom' => ['numeric', 'min:0', Rule::when($this->has('priceTo'), ['lte:priceTo'])],
            'priceTo' => ['numeric', 'min:0', Rule::when($this->has('priceFrom'), ['gte:priceFrom'])],
            //date as unix timestamp
            'dateFrom' => ['numeric', Rule::when($this->has('dateTo'), ['lte:dateTo'])],
            'dateTo' => ['numeric', Rule::when($this->has('dateFrom'), ['gte:dateFrom'])],
            'sort' => [Rule::in(['asc', 'desc'])],
        ];
    }
}
