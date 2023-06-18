<?php

namespace App\Models;

use App\Models\UserLike;
use App\Traits\Models\HasModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, HasModelTrait, SoftDeletes;

    public const STATUS_ACTIVE = 1;

    protected $fillable = ['title', 'content', 'likes', 'status', 'user_id'];

    public function image()
    {
        return $this->morphOne(ServerFile::class, 'uploadable');
    }

    public function likes()
    {
        return $this->morphOne(UserLike::class, 'content');
    }
}
