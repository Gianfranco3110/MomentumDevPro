<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userCourses extends Model
{
    use HasFactory;
    protected $table = 'users_courses';

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id')->withTrashed();
    }


    public function courses()
    {
        return $this->belongsTo('App\Models\course', 'courses_id');
    }

}
