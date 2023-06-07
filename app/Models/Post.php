<?php

namespace App\Models;

use App\Traits\Models\HasModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, HasModelTrait;

    public const STATUS_ACTIVE = 1;

    protected $fillable = ['title', 'content', 'likes', 'status', 'user_id'];
}
