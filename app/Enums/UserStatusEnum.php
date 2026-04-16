<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static ACTIVE()
 * @method static static BLOCK()
 * @method static static INACTIVE()
 */
final class UserStatusEnum extends Enum
{
    const ACTIVE =   'ACTIVE';
    const BLOCK =   'BLOCK';
    const INACTIVE =   'INACTIVE';
}
