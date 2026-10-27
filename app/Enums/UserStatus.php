<?php

namespace App\Enums;

enum UserStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case TimeOff = 'timeoff';
    case Vacation = 'vacation';
    case Sick = 'sick';
    case Fired = 'fired';
}
