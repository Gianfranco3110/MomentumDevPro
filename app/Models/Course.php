<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    protected $fillable = [
        'price',
        'description',
        'applies_to_date',
        'image',
        'CourseName',
        'daysofvalidity',
        'users_id',
        'status_id',
    ];


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id')->withTrashed();
    }

    /**
     * Get the Status that owns the Notes.
     */
    public function status()
    {
        return $this->belongsTo('App\Models\Status', 'status_id');
    }

    public function coursevideo()
    {
        return $this->hasMany('App\Models\course_video', 'courses_id');
    }

    public function coursestudent()
    {
        return $this->hasMany('App\Models\userCourses', 'curso_id');
    }

    public static function video_resentation($id)
    {
        return course_video::where('course_section_id',1)->where('courses_id',$id)->orderBy('order', 'asc')->first();
    }



}
