<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class FeedbackStatusEnum extends Enum
{
    const NEED_APPROVAL =   'NEED_APPROVAL';
    const APPROVED =   'APPROVED';
    const REJECTED =   'REJECTED';
}