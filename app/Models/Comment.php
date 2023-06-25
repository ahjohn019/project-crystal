<?php

namespace App\Models;

use App\Models\ServerFile;
use App\Traits\Models\HasModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory, SoftDeletes, HasModelTrait;

    public const STATUS_ACTIVE = 1;

    protected $fillable = ['content', 'likes', 'status', 'user_id'];

    public function image()
    {
        return $this->morphOne(ServerFile::class, 'uploadable');
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}
