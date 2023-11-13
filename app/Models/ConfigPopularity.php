<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigPopularity extends Model
{
    use HasFactory;

    protected $fillable = ['minimum_value', 'maximum_value', 'type', 'grade'];
}
