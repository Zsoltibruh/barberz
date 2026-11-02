<?php

namespace App\Enums;

enum Role: string
{
    case Admin = 'admin';
    case Customer = 'customer';
    case Barber = 'barber';
    case Owner = 'owner';
}
