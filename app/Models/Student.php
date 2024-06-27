<?php

namespace App\Models;

use App\Enums\SubmissionStatus;
use App\Helpers\GeneralHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Student extends Model
{
    use HasFactory;
    const CALLED = 'student';

    protected $guarded = ['created_at'];
    protected $primaryKey = 'id';
    public $incrementing = false;

    public function getRouteKeyName(): string
    {
        return 'id';
    }

    protected function semester(): Attribute
    {
        return new Attribute(
            get: fn () => GeneralHelper::semester($this->stamp)
        );
    }

    protected function genderFull(): Attribute
    {
        return new Attribute(
            get: fn () => $this->gender == 'L' ? 'Laki-laki' : 'Perempuan'
        );
    }

    public function userable(): MorphOne
    {
        return $this->morphOne(UserType::class, 'userable');
    }

    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(
            User::class,
            UserType::class,
            'userable_id',
            'id',
            'id',
            'user_id'
        )
            ->where('userable_type', \App\Models\Student::class);
    }

    public function supervisorsThrough(): HasMany
    {
        return $this->hasMany(Supervisor::class);
    }

    public function supervisors(): HasManyThrough
    {
        return $this->hasManyThrough(Lecturer::class, Supervisor::class, 'student_id', 'id', 'id', 'lecturer_id')
            ->orderBy('as', 'asc');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class)
            ->latest();
    }

    public function finalProject(): HasOne
    {
        return $this->hasOne(Submission::class)
            ->where('status', SubmissionStatus::approved->name)
            ->latest();
    }

    public function guidances(): HasMany
    {
        return $this->hasMany(Guidance::class);
    }

    public function guidancesHistories(): HasManyThrough
    {
        return $this->hasManyThrough(GuidanceHistory::class, Guidance::class, 'student_id', 'guidance_id', 'id', 'id');
    }

    public function guidancesSubmissions(): HasManyThrough
    {
        return $this->hasManyThrough(GuidanceSubmission::class, Guidance::class, 'student_id', 'guidance_id', 'id', 'id');
    }

    public function guidancesReviews(): HasManyThrough
    {
        return $this->hasManyThrough(Review::class, Guidance::class, 'student_id', 'guidance_id', 'id', 'id');
    }

    public function guidancesRevisions(): HasManyThrough
    {
        return $this->hasManyThrough(Revision::class, Guidance::class, 'student_id', 'guidance_id', 'id', 'id');
    }

    public function passed(): HasOne
    {
        return $this->hasOne(StudentPassed::class);
    }
}
