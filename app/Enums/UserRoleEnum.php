<?php

namespace App\Enums;

enum UserRoleEnum: string 
{
    case ADMIN  = 'Administrator';
    case EDITOR = 'Editor';
    case AUTHOR = 'Author';
    case PUBLIC = 'Public';
}