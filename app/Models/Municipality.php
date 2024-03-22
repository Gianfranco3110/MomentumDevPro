<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_name',
        'states_id'
    ];

    public function states() {
        return $this->belongsTo(States::class);
    }
}
