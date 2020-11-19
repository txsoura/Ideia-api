<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method ticket status enum
 */
final class TicketStatus extends Enum
{
    const APPROVED =  'approved';
    const PENDENT =   'pendent';
    const CANCELED = 'canceled';
}
