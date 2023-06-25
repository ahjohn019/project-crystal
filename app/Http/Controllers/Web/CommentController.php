<?php

namespace App\Http\Controllers\Web;

use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use App\Http\Services\ImageService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Comment\CreateFormRequest;

class CommentController extends Controller
{
    //
    public function list()
    {
        try {
            $comments = Comment::where("status", Comment::STATUS_ACTIVE)->paginate(15);

            return self::successResponse('Comments Display Successfully', $comments);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store(CreateFormRequest $request)
    {
        $payload = $request->validated();

        return DB::transaction(function () use ($payload) {
            try {
                $payload['user_id'] = auth()->user()->id;

                $result = $payload['model']::query()
                    ->where('id', $payload['model_id'])
                    ->firstOrThrowError();

                $comment = $result->comment()->updateOrCreate(['user_id' => $payload['user_id']], $payload);

                if (isset($payload['file'])) {
                    $payload['folder_name'] = 'Comments';
                    $comment->image()->exists() ? ImageService::updateImage($payload, $comment) : ImageService::createImage($payload, $comment);
                }

                return self::successResponse('Comment Created Successfully', $payload);
            } catch (\Throwable $th) {
                return self::failedResponse(class_basename($payload['model']) .  ' Not Found', $th->getMessage());
            }
        });
    }

    public function show($id)
    {
        $comments = Comment::where('id', $id)->firstOrThrowError();

        return self::successResponse('Comment Show Successfully', $comments);
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $comments = Comment::where('id', $id)->firstOrThrowError();
            $payload = $comments->delete();
            $comments->image()->delete();

            return self::successResponse('Comment Deleted Successfully.', $payload);
        });
    }
}
