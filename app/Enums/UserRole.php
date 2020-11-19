<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method user roles enum
 */
final class UserRole extends Enum
{
    const ADMIN =  'admin';
    const CUSTOMER =   'customer';
    const PRODUCER = 'producer';
    const MERCHANT = 'merchant';
}
