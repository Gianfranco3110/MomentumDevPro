<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userCourses extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'curso_id',
        'Fecha_registro',
        'Fecha_vence',
        'Fecha_aprobado',
        'Fecha_compra',
        'Fecha_sesion',
        'Usuario_aprueba',
        'Video_actual',
    ];

    protected $table = 'users_courses';

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id')->withTrashed();
    }


    public function courses()
    {
        return $this->belongsTo('App\Models\course', 'curso_id');
    }

    public function coursevideo()
    {
        return $this->hasMany('App\Models\course_video', 'courses_id');
    }
}
