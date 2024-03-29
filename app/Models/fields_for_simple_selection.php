<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fields_for_simple_selection extends Model
{
    use HasFactory;
    protected $fillable = [
        'options',
        'id_user_questions'
    ];
}
