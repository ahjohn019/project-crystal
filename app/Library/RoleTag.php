<?php

namespace App\Library;

class RoleTag
{

    public const ADMIN = 'admin';

    public const SUPERADMIN = 'superadmin';

    public const USER = 'user';

    public static function getAllAdmin(): array
    {
        return [
            self::ADMIN,
            self::SUPERADMIN
        ];
    }

    public static function getAllUser(): array
    {
        return [
            self::USER,
        ];
    }
}
