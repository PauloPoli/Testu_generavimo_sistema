<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ImplicitRule;

class TrueRule implements ImplicitRule
{


    protected $customValue;
    protected $type;

    public function __construct($type,$customValue)
    {
       
        $this->type = $type;
        $this->customValue =$customValue;
        
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
        $count=0;
     if($this->type === 'Vienas teisingas' || $this->type === 'Keli teisingi') 
     {
        foreach($this->customValue as $custom)
        {
            
            if($value === true)
            {
                $count=$count +1;
            }
            else
            {
                $count=$count +0;
            }
        }
        if($count>0)
        {
            return true;
        }
        else{
            return false;
        }
     }  
    }

   

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Vienas atsakymas privalo buti teisingas';
    }
}