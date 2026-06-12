<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;

class Event extends Model
{
    use SoftDeletes;
    use UserstampsTrait;

    protected $casts = [
        'event_time' => 'datetime',
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_time',
        'title',
        'description',
        'cover_photo',
        'cover_video',
        'tags',
        'slider_1',
        'slider_2',
        'slider_3',
        'slug',
    ];
}



