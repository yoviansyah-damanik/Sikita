<?php

namespace App\Models;

use App\Models\Scopes\LastOrderScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ScopedBy([LastOrderScope::class])]
class GuidanceGroup extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function types(): HasMany
    {
        return $this->hasMany(GuidanceType::class);
    }
}
