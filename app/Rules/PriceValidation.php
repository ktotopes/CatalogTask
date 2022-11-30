<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PriceValidation implements Rule
{
    private float $firstAmount;
    private float $secondAmount;
    private bool $isFirstLessThenSecond;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(?float $firstAmount, ?float $secondAmount, bool $isFirstLessThenSecond = true)
    {
        $this->firstAmount = $firstAmount ?? 0;
        $this->secondAmount = $secondAmount ?? 0;
        $this->isFirstLessThenSecond = $isFirstLessThenSecond;
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
        if (!$this->isFirstLessThenSecond) {
            return $this->firstAmount >= $this->secondAmount;
        }

        return $this->firstAmount <= $this->secondAmount;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->isFirstLessThenSecond
            ? 'Min price should be less then Max price.'
            : 'Max price should be more then Min price.';
    }
}
