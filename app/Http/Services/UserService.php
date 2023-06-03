<?php

namespace App\Http\Services;

use App\Models\User;
use App\Library\RoleTag;

class UserService
{
    public static function allAdminRoles()
    {
        $admins = User::whereHas("roles", function ($query) {
            $query->where("name", RoleTag::ADMIN);
            $query->orWhere("name", RoleTag::SUPERADMIN);
        });

        return $admins;
    }
}
