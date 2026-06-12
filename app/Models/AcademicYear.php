<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Hrshadhin\Userstamps\UserstampsTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicYear extends Model
{
    use SoftDeletes;
    use UserstampsTrait;

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title','start_date', 'end_date', 'status','is_open_for_admission'];


}



