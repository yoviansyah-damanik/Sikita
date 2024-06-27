<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum SubmissionHistoryStatus
{
    use EnumTrait;

    case information;
    case warning;
    case success;
}
