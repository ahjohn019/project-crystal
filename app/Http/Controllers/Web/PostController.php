<?php

namespace App\Http\Controllers\Web;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use App\Http\Services\ImageService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Post\CreateFormRequest;
use App\Http\Requests\Web\Post\PostLikesRequest;
use App\Http\Requests\Web\Post\UpdateFormRequest;

class PostController extends Controller
{
    //
    public function list()
    {
        try {
            $posts = Post::where("status", Post::STATUS_ACTIVE)->paginate(15);

            return self::successResponse('Posts Display Successfully', $posts);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store(CreateFormRequest $request)
    {
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
            $payload['user_id'] = auth()->user()->id;

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
            $posts->image()->delete();

            return self::successResponse('Post Deleted Successfully.', $payload);
        });
    }

    public function sendUserLikes(PostLikesRequest $request)
    {
        try {
            $payload = $request->validated();

            $posts = Post::where('id', $payload['post_id'])
                ->firstOrThrowError();

            $posts->likes()->updateOrCreate([
                'user_id' => auth()->user()->id
            ]);

            $totalPostLikes = $posts->likes()->count();

            $posts->update(['likes' => $totalPostLikes]);

            return self::successResponse('Likes Updated', $posts);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
