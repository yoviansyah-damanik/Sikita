<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Submission extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    const MAX_SUBMISSIONS = 3;

    public function scopeOwned($query): void
    {
        $query->where('student_id', auth()->user()->data->id);
    }

    public function scopeApproval($query): void
    {
        // $query->whereIn('student_id', auth()->guidance);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function supervisor_1(): BelongsTo
    {
        return $this->belongsTo(Lecturer::class, 'id', 'supervisor_1_id');
    }

    public function supervisor_2(): BelongsTo
    {
        return $this->belongsTo(Lecturer::class, 'id', 'supervisor_2_id');
    }

    public function histories(): HasMany
    {
        return $this->hasMany(SubmissionHistory::class)
            ->latest()
            ->limit(10);
    }

    public function latestHistory(): HasMany
    {
        return $this->hasMany(SubmissionHistory::class)
            ->latest()
            ->limit(1);
    }
}
