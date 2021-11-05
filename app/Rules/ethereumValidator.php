<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use kornrunner\Keccak;

class ethereumValidator implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        if ($this->matchesPattern($value)) {
            return $this->isAllSameCaps($value) ?: $this->isValidChecksum($value);
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The wallet address you have entered is not valid!';
    }


    private function matchesPattern(string $address): int
    {
        return preg_match('/^(0x)?[0-9a-f]{40}$/i', $address);
    }

    private function isAllSameCaps(string $address): bool
    {
        return preg_match('/^(0x)?[0-9a-f]{40}$/', $address) || preg_match('/^(0x)?[0-9A-F]{40}$/', $address);
    }

    private function isValidChecksum($address)
    {
        $address = str_replace('0x', '', $address);
        try{
            $hash = Keccak::hash(strtolower($address), 256);
        }catch (\Throwable $e) {
            return false;
        }

        for ($i = 0; $i < 40; $i++ ) {
            if (ctype_alpha($address[$i])) {
                $charInt = intval($hash[$i], 16);
                if ((ctype_upper($address[$i]) && $charInt <= 7) || (ctype_lower($address[$i]) && $charInt > 7)) {
                    return false;
                }
            }
        }

        return true;
    }
}
