<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;

class Registration extends Model
{
    use SoftDeletes;
    use UserstampsTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'regi_no',
        'student_id',
        'class_id',
        'section_id',
        'academic_year_id',
        'roll_no',
        'shift',
        'card_no',
        'board_regi_no',
        'house',
        'status',
        'is_promoted',
        'old_registration_id',
    ];

    public function student()
    {
        return $this->belongsTo('App\Models\Student', 'student_id');
    }

    public function info()
    {
        return $this->belongsTo('App\Models\Student', 'student_id');
    }

    public function class()
    {
        return $this->belongsTo('App\Models\IClass', 'class_id');
    }

    public function section()
    {
        return $this->belongsTo('App\Models\Section', 'section_id');
    }

    public function acYear()
    {
        return $this->belongsTo('App\Models\AcademicYear', 'academic_year_id');
    }

    public function attendance()
    {
        return $this->hasMany('App\Models\StudentAttendance', 'registration_id');
    }

    public function attendanceSingleDay()
    {
        return $this->hasOne('App\Models\StudentAttendance', 'registration_id');
    }

    public function result()
    {
        return $this->hasMany('App\Models\Result', 'registration_id');
    }

    public function marks()
    {
        return $this->hasMany('App\Models\Mark', 'registration_id');
    }

    public function scopeSection($query, $section)
    {
        if($section){
            return $query->where('section_id', $section);
        }

        return $query;
    }

    public function scopeCountOrGet($query, $isCount)
    {
        if($isCount){
            return $query->count();
        }

        return $query->get();
    }

    public function subjects()
    {
        return $this->belongsToMany('App\Models\Subject','student_subjects', 'registration_id', 'subject_id')->withPivot('subject_type')
            ->select('id','name','code','type');
    }
}



