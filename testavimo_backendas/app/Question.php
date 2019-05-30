<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Question extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Type', 'Question_Title','fk_test'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     * 
     */
    protected $hidden = [];

    public function answers()
    {
        return $this->hasMany('App\Answer','fk_question','id');

    }

    
    
}