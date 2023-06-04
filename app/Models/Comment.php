<?php

namespace App\Models;

use App\Models\ServerFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    public function image()
    {
        return $this->morphOne(ServerFile::class, 'uploadable');
    }
}
