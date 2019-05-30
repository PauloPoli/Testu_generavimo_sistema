<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ImplicitRule;

class TypeRule implements ImplicitRule
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
       
        if($value == 'Vienas teisingas' || $value == 'Keli teisingi')
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
        return 'Parinkite tinkama klausimo tipa( Single, Multiple)';
    }
}