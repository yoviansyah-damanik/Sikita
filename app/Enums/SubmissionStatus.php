<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum SubmissionStatus
{
    use EnumTrait;

    case process;
    case approved;
    case rejected;
    case revision;
}
