<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ImplicitRule;

class Available_variantsRule implements ImplicitRule
{


    protected $customValue;

    public function __construct($customValue)
    {
       
            $this->customValue = $customValue;
        
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
        if($this->customValue === 'Vienas teisingas' )
        {
            return true;

        }
        else{
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
        return 'ne vienas teisingas';
    }
}