<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $guarded = ['id'];

    public function scopeOwned($query)
    {
        $query->where('lecturer_id', auth()->user()->data->id);
    }

    public function guidance(): BelongsTo
    {
        return $this->belongsTo(Guidance::class);
    }

    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(Lecturer::class);
    }
}
