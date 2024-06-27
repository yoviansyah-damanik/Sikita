<?php

namespace App\Models;

use App\Models\Scopes\LastOrderScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ScopedBy([LastOrderScope::class])]
class GuidanceType extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function group(): BelongsTo
    {
        return $this->belongsTo(GuidanceGroup::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Guidance::class, 'guidance_type_id', 'id');
    }
}
