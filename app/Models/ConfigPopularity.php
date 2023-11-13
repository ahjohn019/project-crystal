<?php

namespace App\Models;

use App\Traits\HasModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigPopularity extends Model
{
    use HasFactory, HasModelTrait;

    public const FULL_PERCENTAGE = 100;

    protected $fillable = ['minimum_value', 'maximum_value', 'type', 'grade'];
}
