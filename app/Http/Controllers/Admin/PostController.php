<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use App\Http\Services\ImageService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PostResource;
use App\Http\Requests\Web\ListFormRequest;
use App\Http\Requests\Admin\Post\CreateFormRequest;
use App\Http\Requests\Admin\Post\UpdateFormRequest;

class PostController extends Controller
{
    //
    public function list(ListFormRequest $request)
    {
        $payload = $request->validated();

        $postAttribute = $payload['attribute'] ?? Post::CREATED_AT;
        $postSortable = $payload['sortable'] ?? Post::LATEST;

        $posts = Post::where("status", Post::STATUS_ACTIVE)
            ->with('user')
            ->searchable($payload, ['user' => 'name', 'category' => 'name'])
            ->orderBy($postAttribute, $postSortable)
            ->paginate($payload['paginate'] ?? 15);

        $result = PostResource::collection($posts)->response()->getData();

        return self::successResponse('Posts Display Successfully', $result);
    }

    public function store(CreateFormRequest $request)
    {
        //
        $payload = $request->validated();

        return DB::transaction(function () use ($payload) {
            $payload['user_id'] = auth()->user()->id;
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

            if ($posts->user->id != auth()->user()->id) {
                return self::successResponse('You are not allowed to update other people posts');
            }

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
}
