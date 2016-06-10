<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'question', 'answer', 'type_id', 'theme_id', 'qcm_answer_1', 'qcm_answer_2', 'qcm_answer_3', 'qcm_answer_4',
    ];

    protected $hidden = [
        'multiple_answer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo('App\Type');
    }

    public function theme()
    {
        return $this->belongsTo('App\Theme');
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function uriPicture()
    {
        return url('') . '/' . env('UPLOAD_IMAGES', 'uploads') . '/' . $this->picture;
    }
}
