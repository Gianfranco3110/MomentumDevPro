<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class course_video extends Model
{
    use HasFactory;
    protected $table = 'course_videos';

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

}