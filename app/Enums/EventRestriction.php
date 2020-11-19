<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method event restriction enum
 */
final class EventRestriction extends Enum
{
    const NONE =  'none';
    const ONLY_CHILDREN =   'only_children';
    const NO_CHILDREN =   'no_children';
    const WOMAN_ONLY =   'woman_only';
    const OLDER =   'older';
}
