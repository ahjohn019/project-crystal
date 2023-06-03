<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Services\UserService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\Admin\CreateFormRequest;
use App\Http\Requests\Admin\Admin\UpdateFormRequest;

class AdminController extends Controller
{
    //
    public function index()
    {
        return auth()->user();
    }

    public function list()
    {
        //
        $adminList = UserService::allAdminRoles()->get();

        return self::successResponse('Success', $adminList);
    }

    public function store(CreateFormRequest $request)
    {
        $payload = $request->validated();

        return DB::transaction(function () use ($payload) {
            $payload['password'] = isset($payload['password']) ? Hash::make($payload['password']) : 'P@ssword';
            User::create($payload);

            return self::successResponse('Admin Created Successfully.', $payload);
        });
    }

    public function show($id)
    {
        //
        $result = UserService::allAdminRoles()->where('id', $id)->firstOrThrowError();

        return self::successResponse('Admin Display Successfully.', $result);
    }

    public function update(UpdateFormRequest $request)
    {
        $payload = $request->validated();

        return DB::transaction(function () use ($payload) {
            $result = User::where('id', $payload['id'])->update($payload);

            return self::successResponse('Admin Update Successfully.', $result);
        });
    }

    public function delete($id)
    {
        $payload = User::find($id)->delete();

        return self::successResponse('Admin Deleted Successfully.', $payload);
    }
}
