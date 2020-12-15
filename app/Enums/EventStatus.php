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
    const TICKET_OUT = 'ticket_out'; //no ticket available
    const OUT = 'out'; //event not visible
    const CANCELED = 'canceled'; //canceled event
    const BLOCKED = 'blocked'; //event blocked by a report human for any reason
}
