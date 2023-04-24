<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum UserRole: string 
{
    use Values;

    case ADMIN  = 'administrator';
    case EDITOR = 'editor';
    case AUTHOR = 'author';
    case PUBLIC = 'public';

    public function label() {
        return match ($this) {
            self::ADMIN => 'Administrator',
            self::EDITOR=> 'Editor',
            self::AUTHOR=> 'Author',
            self::PUBLIC=> 'Public'
        };
    }
}