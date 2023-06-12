<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use App\Http\Services\ImageService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\CreateFormRequest;
use App\Http\Requests\Admin\Post\UpdateFormRequest;

class PostController extends Controller
{
    //
    public function list()
    {
        $posts = Post::where("status", Post::STATUS_ACTIVE)->paginate(15);

        return self::successResponse('Posts Display Successfully', $posts);
    }

    public function store(CreateFormRequest $request)
    {
        //
        $payload = $request->validated();

        return DB::transaction(function () use ($payload) {
            $posts = Post::create($payload);

            if (isset($payload['file'])) {
                $payload['folder_name'] = 'Posts';
                $result = ImageService::createImage($payload, $posts);

                return self::successResponse('Post Images Created Successfully', $result);
            }


            return self::successResponse('Post Created Successfully', $payload);
        });
    }

    public function show($id)
    {
        $posts = Post::where('id', $id)->firstOrThrowError();

        return self::successResponse('Post Show Successfully', $posts);
    }

    public function update(UpdateFormRequest $request)
    {
        $payload = $request->validated();

        return DB::transaction(function () use ($payload) {
            $posts = Post::where('id', $payload['id'])->firstOrThrowError();
            $result = $posts->update($payload);

            if (isset($payload['file'])) {
                $payload['folder_name'] = 'Posts';
                $result = ImageService::updateImage($payload, $posts);

                return self::successResponse('Post Images Updated Successfully', $result);
            }

            return self::successResponse('Post Update Successfully.', $result);
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $posts = Post::where('id', $id)->firstOrThrowError();
            $payload = $posts->delete();

            return self::successResponse('Post Deleted Successfully.', $payload);
        });
    }
}
