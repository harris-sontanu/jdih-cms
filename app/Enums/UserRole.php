<?php

namespace App\Enums;

enum UserRole: string 
{
    case ADMIN  = 'administrator';
    case EDITOR = 'editor';
    case AUTHOR = 'author';
    case PUBLIC = 'public';
}