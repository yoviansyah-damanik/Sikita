<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Guidance extends Model
{
    protected $guarded = ['id'];
    public $routeKeyName = 'id';

    public function isFinish(): Attribute
    {
        return new Attribute(
            get: fn () => $this->revisions->sum(fn ($revision) => $revision->revisionOnly()->count()) > 0 ? false : true
        );
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(GuidanceSubmission::class)
            ->latest();
    }

    public function histories(): HasMany
    {
        return $this->hasMany(GuidanceHistory::class)
            ->latest();
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(Revision::class)
            ->oldest();
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(GuidanceType::class, 'guidance_type_id', 'id');
    }

    public function group(): HasOneThrough
    {
        return $this->hasOneThrough(GuidanceGroup::class, GuidanceType::class, 'id', 'id', 'guidance_type_id', 'guidance_group_id');
    }
}
