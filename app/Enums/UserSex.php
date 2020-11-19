<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method user sex enum
 */
final class UserSex extends Enum
{
    const MALE =  'male';
    const FEMALE =   'female';
    const OTHER =   'other';
}
