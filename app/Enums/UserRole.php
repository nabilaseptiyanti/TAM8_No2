<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case User = 'user';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::User => 'User',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Admin => 'bg-danger text-white',
            self::User => 'bg-primary text-white',
        };
    }
}
