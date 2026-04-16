<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static MALE()
 * @method static static FEMALE()
 * @method static static OTHER()
 */
final class GenderEnum extends Enum
{
    const MALE =   'MALE';
    const FEMALE =   'FEMALE';
    const OTHER =   'OTHER';
}
