<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;

class googleRecaptchaValidation implements Rule
{
    private $msg = "Invalid Google Recaptcha response!";

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
        if(empty($value)){
            $this->msg = "Completing Google Recaptcha is required!";
            return false;
        }

        try
        {
            $response = Http::get('https://www.google.com/recaptcha/api/siteverify', [
                'secret'   => config('custom.recaptcha.secret_key'),
                'response' => $value,
                //'remoteip' => request()->ip()
            ])->throw()->json();
        }
        catch (\Throwable $e)
        {
            return false;
        }

        if(isset($response['success'],$response['hostname'])){
            if($response['success'] === true
               // && $response['hostname'] == request()->getHttpHost()
            ){
                return true;
            }
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
        return $this->msg;
    }
}
