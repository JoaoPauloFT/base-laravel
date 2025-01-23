<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CommissionRuleMin implements Rule
{
    protected $field;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($field = "")
    {
        $this->field = $field;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $valor = floatval(str_replace(',', '.', str_replace('.', '', $value)));
        $min = floatval(str_replace(',', '.', str_replace('.', '', request()->input($this->field))));

        if (!$value)
            return true;

        if ($this->field == "")
            return $valor >= 0;
        else
            return $valor > $min;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O campo :attribute deve ser maior que o campo ' . __('validation.attributes.'.$this->field) . '.';
    }
}
