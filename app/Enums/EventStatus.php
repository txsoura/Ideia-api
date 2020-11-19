<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method event status enum
 */
final class EventStatus extends Enum
{
    const AVAILABLE =  'available';
    const PENDENT =   'pendent';
    const WITHOUT_TICKET = 'without_ticket';
    const OUT_TICKET = 'out_ticket';
    const OUT = 'out';
}
