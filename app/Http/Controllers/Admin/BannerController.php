<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Banner\CreateFormRequest;
use App\Http\Requests\Admin\Banner\UpdateFormRequest;

class BannerController extends Controller
{
    public function list()
    {
        $banner = Banner::orderByRaw("seq_value ASC, created_at DESC")
            ->paginate(15);

        return self::successResponse('Banner Display Successfully', $banner);
    }

    public function store(CreateFormRequest $request)
    {
        $payload = $request->validated();

        return DB::transaction(function () use ($payload) {
            Banner::create($payload);

            return self::successResponse('Banner Created Successfully', $payload);
        });
    }

    public function show($id)
    {
        $result = Banner::where('id', $id)->firstOrThrowError();

        return self::successResponse('Banner Display Successfully', $result);
    }

    public function update(UpdateFormRequest $request)
    {
        $payload = $request->validated();

        return DB::transaction(function () use ($payload) {
            $banner = Banner::where('id', $payload['id'])->firstOrThrowError();
            $result = $banner->update($payload);

            return self::successResponse('Banner Update Successfully.', $result);
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $banner = Banner::where('id', $id)->firstOrThrowError();
            $payload = $banner->delete();

            return self::successResponse('Banner Deleted Successfully.', $payload);
        });
    }
}
