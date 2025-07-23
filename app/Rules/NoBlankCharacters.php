<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class NoBlankCharacters implements ValidationRule
{
    private const string BLANK_CHARACTERS_PATTERN = '/^[\s\x{2005}\x{2006}\x{2007}\x{2008}\x{2009}\x{200A}\x{2028}\x{205F}\x{3000}]*$/u';

    private const string FORMAT_CHARACTERS_PATTERN = '/\p{Cf}/u';
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = is_scalar($value) ? (string) $value : '';

        if (preg_match(self::BLANK_CHARACTERS_PATTERN, $value) || preg_match(self::FORMAT_CHARACTERS_PATTERN, $value)) {
            $fail('The :attribute field cannot contain blank characters.');
        }
    }
}
