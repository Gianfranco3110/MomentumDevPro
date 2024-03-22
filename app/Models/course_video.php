<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class course_video extends Model
{
    use HasFactory;
    protected $table = 'course_videos';
    protected $fillable = [
        'course_section_id',
        'order',
        'description',
        'url_video',
        'courses_id',
        'users_id',
        'status_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id')->withTrashed();
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Status', 'status_id');
    }

    public function courses()
    {
        return $this->belongsTo('App\Models\course', 'courses_id');
    }

    // public function courseSection()
    // {
    //     return $this->belongsTo('App\Models\CourseSection','course_section_id');
    // }
}
