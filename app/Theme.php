<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = [
        'name', 'slug',
    ];

    public function questions()
    {
        return $this->hasMany('App\Question');
    }
    
     public function results()
    {
        return $this->hasMany('App\Result');
    }
}