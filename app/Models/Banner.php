<?php

namespace App\Models;

use App\Models\ServerFile;
use App\Traits\HasModelTrait;
use App\Traits\ServerFileTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends Model
{
    use HasFactory, SoftDeletes, HasModelTrait, ServerFileTrait;

    protected $fillable = ['name', 'seq_value'];

    public function image()
    {
        return $this->morphOne(ServerFile::class, 'uploadable');
    }
}
