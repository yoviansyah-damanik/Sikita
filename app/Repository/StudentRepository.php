<?php

namespace App\Repository;

use App\Models\Student;
use App\Models\Guidance;
use App\Enums\RevisionStatus;
use App\Enums\SupervisorType;
use App\Models\GuidanceGroup;
use App\Helpers\GeneralHelper;
use App\Enums\SubmissionStatus;

interface StudentInterface
{
    public static function getStudent(
        Student | int $student,
        string | Guidance $guidanceGroup,
        ?string $guidanceTypeId
    ): array;
    public static function getAll(
        array $searchColumns,
        int $limit,
        ?string $search,
        string $studentStatus,
        ?int $semester,
        string $searchType,
        string | Guidance $guidanceGroup,
        ?string $guidanceTypeId,
        string | array | null $lecturerId,
        string $activationType,
        string $passType,
    ): \Illuminate\Pagination\LengthAwarePaginator | array;
    public function mapping(Student $student): array;
    public static function getGuidances(Student $student): array;
    public static function getSubmissions(Student $student): array;
    public static function getSupervisors(Student $student): array;
    public static function getGuidancesHistories(?Guidance $guidance): array;
    public static function getGuidancesSubmissions(?Guidance $guidance): array;
    public static function getGuidancesRevisions(?Guidance $guidance): array;
}

class StudentRepository implements StudentInterface
{
    const LIMIT_DEFAULT = 10;
    const WITH = [
        'user',
        'submissions',
        'submissions.histories',
        'guidances',
        'guidances.histories',
        'guidances.submissions',
        'guidances.revisions',
        'guidances.reviews',
        'supervisors',
    ];

    private static $guidanceGroup;
    private static $guidanceTypeId;

    // JUMLAH HARUS 100
    const MAX_SUBMISSION = 20;
    const MAX_GUIDANCE = 80;

    public static function getStudent(Student | int $student, string | Guidance $guidanceGroup = 'all', ?string $guidanceTypeId = null): array
    {
        if (gettype($student) == 'integer') {
            $student = Student::find($student);
        }

        static::$guidanceGroup = $guidanceGroup;
        static::$guidanceTypeId = $guidanceTypeId;
        return (new self)->mapping($student->load(self::WITH));
    }

    /**
     * @param string $searchColumns array - default ['name] | available columns: id, name
     * @param string $studentStatus 'all' | 'passed' | 'progress'
     * @param string $guidanceGroup | Guidance Group: 'all' OR id of Guidance Group
     */
    public static function getAll(
        array $searchColumns = ['name'],
        int $limit = self::LIMIT_DEFAULT,
        ?string $search = null,
        string $studentStatus = 'all',
        ?int $semester = null,
        string $searchType = 'all',
        string | Guidance $guidanceGroup = 'all',
        ?string $guidanceTypeId = null,
        string | array | null $lecturerId = null,
        string $activationType = 'all',
        string $passType = 'all',
    ): \Illuminate\Pagination\LengthAwarePaginator | array {
        static::$guidanceGroup = $guidanceGroup;
        static::$guidanceTypeId = $guidanceTypeId;

        $result = Student::with(self::WITH)
            ->whereAny($searchColumns, 'like', "$search%");

        if ($searchType != 'all') {
            if ($searchType == 'supervisor') {
                $result = $result->whereHas('supervisors', function ($q) {
                    $q->where('lecturer_id', auth()->user()->data->id);
                });
            }

            if ($searchType == 'guidances_student') {
                $result = $result->whereHas('supervisors', function ($q) use ($lecturerId) {
                    if (is_array($lecturerId)) $q->whereIn('lecturer_id', $lecturerId);
                    else $q->where('lecturer_id', $lecturerId);
                });
            }

            if ($searchType == 'approval') {
                $result = $result->has('submissions');
            }

            if ($studentStatus == 'progress') {
                $result = $result->whereHas('submissions', fn ($q) => $q->where('status', SubmissionStatus::approved->name));
            }
        }

        if ($activationType != 'all') {
            if ($activationType == 'suspended') {
                $result = $result->whereHas('user', function ($q) {
                    $q->where('is_suspended', true);
                });
            }

            if ($activationType == 'active') {
                $result = $result->whereHas('user', function ($q) {
                    $q->where('is_suspended', false);
                });
            }
        }
        if ($passType != 'all') {
            if ($passType == 'passed') {
                $result = $result->whereHas('passed');
            }

            if ($passType == 'not_yet_passed') {
                $result = $result->whereDoesntHave('passed');
            }
        }

        $result = $result->orderBy('stamp', 'desc')
            ->orderBy('name', 'asc')
            ->paginate($limit);

        return tap($result, function ($paginatedInstance) {
            return $paginatedInstance->getCollection()->transform(function ($value) {
                return (new self)
                    ->mapping($value);
            });
        });
    }

    public function mapping(Student $student): array
    {
        $submissions = static::getSubmissions($student);
        $finalProject = collect($submissions)->where('status', SubmissionStatus::approved->name)->first() ?
            [
                'data' => collect($submissions)
                    ->where('status', SubmissionStatus::approved->name)->first(),
                'guidances' => static::getGuidances($student),
            ] : [];

        $percentage = 0;
        if (collect($submissions)->some(fn ($submission) => collect($submission)->where('status', SubmissionStatus::approved->name)))
            $percentage += self::MAX_SUBMISSION;

        if (!empty($finalProject)) {
            $additionalPercentage = collect($finalProject['guidances'])
                ->sum(
                    function ($guidance) {
                        return collect($guidance['types'])->sum('percentage');
                    }
                );
            $percentage += $additionalPercentage;
        }

        $isPassed = $student?->passed;

        if ($isPassed) {
            $percentage = 100;
        }

        if (round($percentage) < 20) {
            $status = [
                'code' => 0,
                'message' => __("Not yet submitted")
            ];
        } else if (round($percentage) >= 20 && round($percentage) < 100) {
            $status = [
                'code' => 1,
                'message' => __("On Progress")
            ];
        } else {
            $status = [
                'code' => 2,
                'message' => __("Finish")
            ];
        }

        $isFinish = !empty($finalProject['guidances'])  ? collect($finalProject['guidances'])
            ->every(fn ($guidance) => $guidance['is_finish']) : false;

        return [
            'data' => [
                'npm' => $student->id,
                'name' => $student->name,
                'place_of_birth' => $student->place_of_birth,
                'date_of_birth' => $student->date_of_birth,
                'address' => $student->address,
                'gender' => $student->genderFull,
                'semester' => GeneralHelper::semester($student->stamp),
                'stamp' => $student->stamp,
                'phone_number' => $student->phone_number,
            ],
            'user' => $student->user->only(['id', 'email', 'last_login_at', 'is_suspended']),
            'supervisors' => static::getSupervisors($student),
            'submissions' => $submissions,
            'final_project' => $finalProject,
            'is_passed' => [
                'status' => $isPassed ? true : false,
                'message' => $isPassed ? __('Passed') : __('Not Yet Passed'),
                'data' => $isPassed ? $isPassed->only('grade', 'grade_number', 'semester', 'year') : null
            ],
            'is_finish' => $isFinish,
            'percentage' => round($percentage) > 100 ? 100 : round($percentage),
            'status' => $status
        ];
    }

    public static function getGuidances(Student $student): array
    {
        $guidances = GuidanceGroup::with('types');

        if (static::$guidanceGroup != 'all') {
            $guidances = $guidances->where('id', static::$guidanceGroup);
        }
        if (static::$guidanceTypeId) {
            $guidances = $guidances->whereHas('types', fn ($q) => $q->where('id', static::$guidanceTypeId));
        }

        $groupTotal = $guidances->count();
        $groupPercentage = self::MAX_GUIDANCE / $groupTotal;

        $guidances = $guidances->get()->map(
            function ($group) use ($student, $groupPercentage) {
                $types = $group->types;
                $typePercentage = $groupPercentage / ($types->count() == 0  ? 1 : $types->count());

                if (static::$guidanceTypeId) {
                    $types = $types->where('id', static::$guidanceTypeId);
                }

                $result =  [
                    ...$group->only('id', 'name', 'description'),
                    'types' => $types->map(
                        function ($type) use ($student, $typePercentage) {
                            $percentage = 0;

                            $guidance = $student->guidances->where('guidance_type_id', $type->id)->first();
                            $submissions = static::getGuidancesSubmissions($guidance);
                            $histories = static::getGuidancesHistories($guidance);
                            $revisions = static::getGuidancesRevisions($guidance);
                            $reviewers = static::getGuidancesReviews($guidance, static::getSupervisors($student));

                            if (count($submissions) > 0)
                                $percentage += $typePercentage / 3;

                            $reviewerPercentage = $typePercentage * 2 / 3;

                            foreach ($reviewers as $reviewer) {
                                if ($reviewer['status'] == 'approved')
                                    $percentage += $reviewerPercentage / count($reviewers);
                            }

                            return [
                                ...$type->only('id', 'name', 'description'),
                                'guidance_id' => $guidance->id ?? null,
                                'submissions' => $submissions,
                                'histories' => $histories,
                                'revisions' => $revisions,
                                'reviewers' => $reviewers,
                                'is_reviewed' => $reviewers && collect($reviewers)->every(fn ($review) => $review['status'] == 'approved'),
                                'percentage' => $percentage,
                                'max_percentage' => $typePercentage,
                            ];
                        }
                    )
                        ->values()
                        ->toArray(),
                    'max_percentage' => $groupPercentage
                ];

                $result = [
                    ...$result,
                    'is_finish' => collect($result['types'])->every('is_reviewed')
                ];

                return $result;
            }
        )
            ->values()
            ->toArray();

        return $guidances;
    }

    public static function getSubmissions(Student $student): array
    {
        return $student->submissions->count() ? $student->submissions->toArray() : [];
    }

    public static function getSupervisors(Student $student): array
    {
        return $student->supervisors->count() ?
            $student->supervisors->map(function ($supervisor, $idx) {
                return [
                    'as' => $idx == 1 ? SupervisorType::supervisor_1->name : SupervisorType::supervisor_2->name,
                    'nidn' => $supervisor->id,
                    'name' => $supervisor->name,
                    'gender' => $supervisor->genderFull
                ];
            })
            ->sortBy('as')
            ->values()
            ->toArray()
            : [];
    }

    public static function getGuidancesHistories(?Guidance $guidance): array
    {
        return $guidance ? $guidance->histories->toArray() : [];
    }

    public static function getGuidancesSubmissions(?Guidance $guidance): array
    {
        return $guidance ? $guidance->submissions
            ->map(
                fn ($submission) => [
                    ...$submission->toArray(),
                    'storageFile' => $submission->storageFile(),
                    'fullStorageFile' => $submission->storageFile(true)
                ]
            )->toArray() : [];
    }

    public static function getGuidancesReviews(?Guidance $guidance, Object | array $supervisors): ?array
    {
        return $guidance ?
            collect($supervisors)->map(function ($supervisor) use ($guidance) {
                $review = $guidance->reviews->where('lecturer_id', $supervisor['nidn'])->first();

                return [
                    ...collect($supervisor)->only('nidn', 'name', 'as'),
                    'review' => $review ? $review->review : null,
                    'status' => $review ? $review->status : null,
                    'action_time' => $review ? $review->updated_at : null
                ];
            })->toArray()
            : [];
    }

    public static function getGuidancesRevisions(?Guidance $guidance): array
    {
        return $guidance ?
            [
                'data' => $guidance->revisions->toArray(),
                'count' =>
                [
                    'total' => $guidance->revisions->count() ?? 0,
                    'done' => $guidance->revisions->where('status', RevisionStatus::done->name)->count() ?? 0,
                    'on_progress' => $guidance->revisions->where('status', RevisionStatus::onProgress->name)->count() ?? 0,
                ]
            ] : [];
    }
}
