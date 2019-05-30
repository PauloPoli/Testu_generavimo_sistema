<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Test extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Title'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     * 
     */
    protected $hidden = [];




    public function questions()
    {
        return $this->hasMany('App\Question','fk_test','id');
    }

   
    
    
}