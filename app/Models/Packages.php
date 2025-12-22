<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    protected $table = 'packages';

    protected $fillable = [
        'name',
        'price',
        'duration_days',
        'max_guests',
        'max_gallery',
        'custom_domain',
        'is_active',
    ];
}
