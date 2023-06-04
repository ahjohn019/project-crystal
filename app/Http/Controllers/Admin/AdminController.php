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
    public function list()
    {
        //
        $adminList = UserService::allAdminRoles()->paginate(15);

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

            $user = User::where('id', $payload['id'])->firstOrThrowError();
            $result = $user->update($payload);

            return self::successResponse('Admin Update Successfully.', $result);
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $user = User::where('id', $id)->firstOrThrowError();
            $payload = $user->delete();

            return self::successResponse('Admin Deleted Successfully.', $payload);
        });
    }
}
