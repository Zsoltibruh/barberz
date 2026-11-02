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

    public function label(): string
    {
        return match ($this) {
            self::Active => __('active'),
            self::Inactive => __('inactive'),
            self::TimeOff => __('timeoff'),
            self::Vacation => __('vacation'),
            self::Sick => __('sick'),
            self::Fired => __('fired'),
        };
    }
}
