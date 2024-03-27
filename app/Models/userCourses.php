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

    public static function verificarCursoExpirado($user_id)
    {
        $course = self::where('usuario_id',$user_id)->with('courses')->get();
        $currentDate = now();
        foreach ($course as $key => $value) {
            $applies_to_date = \Carbon\Carbon::parse($value->courses->applies_to_date);
            if ($applies_to_date->lessThan($currentDate)) {
                Course::where('id',$value->courses->id)->update(["status_id"=>3]);
            }
        }
    }
}
