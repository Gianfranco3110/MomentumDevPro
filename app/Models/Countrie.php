<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Countrie extends Model
{
    use HasFactory;
    protected $fillable = [
        'country_name',
        "country_short_name",
        "country_phone_code"
    ];

    public function States() {
        return $this->hasMany('App\Models\States');
    }
}
