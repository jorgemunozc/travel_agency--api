<?php

declare(strict_types=1);

namespace App\Enums;

enum Roles: string
{
    case Admin = 'admin';
    case Editor = 'editor';
    case Normal = 'normal';
}
