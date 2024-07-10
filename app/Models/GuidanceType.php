<?php

namespace App\Models;

use App\Models\Scopes\LastOrderScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

#[ScopedBy([LastOrderScope::class])]
class GuidanceType extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function group(): BelongsTo
    {
        return $this->belongsTo(GuidanceGroup::class);
    }

    public function students(): HasManyThrough
    {
        return $this->hasManyThrough(Student::class, Guidance::class, 'id', 'id', 'guidance_type_id', 'student_id');
    }
}
