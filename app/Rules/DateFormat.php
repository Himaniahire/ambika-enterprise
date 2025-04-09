<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DateFormat implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }

    protected $format;

    public function __construct($format = 'd-m-Y')
    {
        $this->format = $format;
    }

    public function passes($attribute, $value)
    {
        return Carbon::createFromFormat($this->format, $value) !== false;
    }

    public function message()
    {
        return 'The :attribute does not match the format ' . $this->format;
    }
}
