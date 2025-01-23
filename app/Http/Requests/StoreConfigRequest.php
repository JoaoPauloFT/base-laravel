<?php

namespace App\Http\Requests;

use App\Rules\CommissionRuleMin;
use Illuminate\Foundation\Http\FormRequest;

class StoreConfigRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'store_name' => [
                'required'
            ],
            'return_date' => [
                'required',
                'numeric',
                'min:1'
            ],
            'payment_term' => [
                'required',
                'numeric',
                'min:1'
            ],
            'type_print' => [
                'required',
                'in:1,2'
            ],
            'min_value_1' => [
                'required',
                new CommissionRuleMin(),
            ],
            'max_value_1' => [
                new CommissionRuleMin('min_value_1')
            ],
            'min_value_2' => [
                new CommissionRuleMin('max_value_1')
            ],
            'max_value_2' => [
                new CommissionRuleMin('min_value_2')
            ],
            'min_value_3' => [
                new CommissionRuleMin('max_value_2')
            ],
            'max_value_3' => [
                new CommissionRuleMin('min_value_3')
            ],
            'min_value_4' => [
                new CommissionRuleMin('max_value_3')
            ],
            'max_value_4' => [
                new CommissionRuleMin('min_value_4')
            ],
        ];
    }
}
