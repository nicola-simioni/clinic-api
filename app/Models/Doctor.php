<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'specialization',
        'email',
        'is_active',
    ];

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }
}