<?php

declare(strict_types=1);

namespace Admin\Enum;

enum UserState: string
{
    case REGISTERED = 'registered';
    case VERIFIED = 'verified';
    case BLOCKED = 'blocked';
}
