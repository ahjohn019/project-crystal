<?php

namespace App\Models;

use App\Traits\Models\HasModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServerFile extends Model
{
    use HasFactory, SoftDeletes, HasModelTrait;

    protected $fillable = [
        'name',
        'disk',
        'module_path',
        'file_type_id',
        'mime_type',
        'extension',
        'size',
        'ori_file',
        'uploadable_id'
    ];

    public const FILE_TYPE_VIDEO = 1;

    public const PDF = 2;

    public const FILE_TYPE_IMAGE = 3;

    public const MODULE_PATH_BANNER_WEB_IMAGE = 'banner-web-image';

    public function uploadable()
    {
        return $this->morphTo();
    }
}
