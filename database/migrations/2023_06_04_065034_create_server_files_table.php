<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('server_files', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('file_type_id');
            $table->string('disk');
            $table->string('module_path');
            $table->morphs('uploadable');
            $table->string('mime_type')->default('');
            $table->string('extension')->default('');
            $table->integer('size')->default(0);
            $table->integer('priority')->default(0);
            $table->string('ori_file')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('server_files');
    }
};
