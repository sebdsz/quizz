<?php

namespace App;

use App\Question;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'score', 'user_id', 'theme_id',
    ];

    protected $dates = [
        'created_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function theme()
    {
        return $this->belongsTo('App\Theme');
    }

    public function maxQuestions($theme_id)
    {
        $maxQuestions = Question::where('theme_id', $theme_id)->get()->count();

        return $maxQuestions;
    }

    public function date()
    {
        setlocale(LC_TIME, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');
        return ucfirst(utf8_encode($this->created_at->formatLocalized('%A %e %B %Y &agrave; %H:%M')));
    }

    public function setCreatedAtAttribute()
    {
        $createdAt = Carbon::now();
        $this->attributes['created_at'] = $createdAt->addHours(2);
    }

    public function getScoreAttribute($value)
    {
        return round($value, 2);
    }
}
