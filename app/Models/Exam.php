<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;

class Exam extends Model
{
    use SoftDeletes;
    use UserstampsTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'class_id',
        'name',
        'elective_subject_point_addition',
        'marks_distribution_types',
        'status',
        'open_for_marks_entry'
    ];


    public function class()
    {
        return $this->belongsTo('App\Models\IClass', 'class_id');
    }

    public function scopeIclass($query, $classId)
    {
        if($classId){
            return $query->where('class_id', $classId);
        }

        return $query;
    }

    public function marks()
    {
        return $this->hasMany('App\Models\Mark', 'exam_id');

    }

    public function result()
    {
        return $this->hasMany('App\Models\Result', 'exam_id');

    }
}



