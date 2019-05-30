<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ImplicitRule;

class TyperuleNotEmty implements ImplicitRule
{


   

    public function __construct()
    {
        
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
       if(!empty($value))
       {
           
       return true;
           
       }
       else
       {
           return false;
       }
    }

   
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Uzpildykite  tipo lauka';
    }
}