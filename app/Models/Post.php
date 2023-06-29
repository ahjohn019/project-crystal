<?php

namespace App\Models;

use App\Models\User;
use App\Models\UserLike;
use App\Traits\HasModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, HasModelTrait, SoftDeletes;

    public const STATUS_ACTIVE = 1;

    protected $fillable = ['title', 'content', 'likes', 'status', 'user_id', 'category_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function image()
    {
        return $this->morphOne(ServerFile::class, 'uploadable');
    }

    public function likes()
    {
        return $this->morphOne(UserLike::class, 'content');
    }

    public function comment()
    {
        return $this->morphOne(Comment::class, 'commentable');
    }
}
