<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StrongPassword implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/[A-Z]/', $value) || 
            !preg_match('/[a-z]/', $value) || 
            !preg_match('/[0-9]/', $value) || 
            !preg_match('/[^A-Za-z0-9]/', $value)) {
            $fail(trans('The :attribute must contain at least one uppercase letter, one lowercase letter, one number, and one special character.'));
        }
    }
}