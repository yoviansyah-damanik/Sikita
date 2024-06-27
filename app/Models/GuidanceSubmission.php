<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuidanceSubmission extends Model
{
    protected $guarded = ['id'];

    public function storageFile(bool $isFull = false)
    {
        return $isFull ? url(Storage::url($this->filepath)) : Storage::url($this->filepath);
    }

    public function guidance(): BelongsTo
    {
        return $this->belongsTo(Guidance::class);
    }
}
