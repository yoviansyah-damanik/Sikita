<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum RevisionStatus: string
{
    use EnumTrait;

    case done = 'Done';
    case onProgress = 'On Progress';
}
