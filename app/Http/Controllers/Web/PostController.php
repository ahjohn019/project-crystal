<?php

namespace App\Http\Controllers\Web;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use App\Http\Services\ImageService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ListFormRequest;
use App\Http\Requests\Web\Post\PostLikesRequest;
use App\Http\Requests\Web\Post\CreateFormRequest;
use App\Http\Requests\Web\Post\UpdateFormRequest;

class PostController extends Controller
{
    //
    public function list(ListFormRequest $request)
    {
        try {
            $payload = $request->validated();

            $posts = Post::where("status", Post::STATUS_ACTIVE)
                ->with('user', 'category')
                ->searchable($payload, ['user', 'category'])
                ->orderBy('created_at', 'desc')
                ->paginate($payload['paginate'] ?? 15);

            return self::successResponse('Posts Display Successfully', $posts);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store(CreateFormRequest $request)
    {
        $payload = $request->validated();

        return DB::transaction(function () use ($payload) {
            $payload['user_id'] = auth()->user()->id;
            $posts = Post::create($payload);

            if (isset($payload['file'])) {
                $payload['folder_name'] = 'Posts';
                ImageService::createImage($payload, $posts);
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

            $posts = Post::where('id', $payload['id'])->with('user')->firstOrThrowError();

            if ($posts->user->id != auth()->user()->id) {
                return self::successResponse('You are not allowed to update other people posts');
            }

            $result = $posts->update($payload);

            if (isset($payload['file'])) {
                $payload['folder_name'] = 'Posts';
                ImageService::updateImage($payload, $posts);
            }

            return self::successResponse('Post Update Successfully.', $result);
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $posts = Post::where('id', $id)->with('user')->firstOrThrowError();

            if ($posts->user->id != auth()->user()->id) {
                return self::successResponse('You are not allowed to delete other people posts');
            }

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

            if ($payload['likes']) {
                $posts->likes()->withTrashed()->where('user_id', auth()->user()->id)->restore();

                $posts->likes()->updateOrCreate([
                    'user_id' => auth()->user()->id
                ]);
            } else {
                $posts->likes()->where('user_id', auth()->user()->id)->delete();
            }

            $totalPostLikes = $posts->likes()->count();

            $posts->update(['likes' => $totalPostLikes]);

            return self::successResponse('Likes Updated', $posts);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
