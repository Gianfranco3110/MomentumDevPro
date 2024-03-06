<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_questions extends Model
{
    use HasFactory;
    protected $table = 'User_questions';

    public function status()
    {
        return $this->belongsTo('App\Models\Status', 'status_id');
    }

    public function courses()
    {
        return $this->belongsTo('App\Models\course', 'courses_id');
    }

    public function courseSection()
    {
        return $this->belongsTo('App\Models\CourseSection','course_section_id');
    }
}
