<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;

class AtLeastOneRequired implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

     protected $fields;

     public function __construct(array $fields)
     {
         $this->fields = $fields;
     }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        Log::info("validate");
        foreach ($this->fields as $field) {
            if (request()->filled($field)) {
                return;
            }
        }

        $fail('At least one of the following fields must have a value.');
    }
}
