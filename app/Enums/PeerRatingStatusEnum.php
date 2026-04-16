<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static NEED_APPROVAL()
 * @method static static APPROVED()
 * @method static static REJECTED()
 */
final class PeerRatingStatusEnum extends Enum
{
    const NEED_APPROVAL =   'NEED_APPROVAL';
    const APPROVED =   'APPROVED';
    const REJECTED =   'REJECTED';
}
