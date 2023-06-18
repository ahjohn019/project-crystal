<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserLike extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'content_id'];

    public function content()
    {
        $this->morphTo();
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
