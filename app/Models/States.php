<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    use HasFactory;
    protected $fillable = [
        'state_name',
    ];

    public function municipalitys() {
        return $this->hasMany('App\Models\Municipality');
    }
}
