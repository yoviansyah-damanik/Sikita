<?php

namespace App\Livewire;

use App\Enums\SubmissionStatus;
use App\Models\Staff;
use App\Enums\UserType;
use App\Models\Student;
use Livewire\Component;
use App\Models\Lecturer;
use App\Models\Register;
use App\Models\GuidanceGroup;
use App\Models\GuidanceSubmission;
use App\Models\GuidanceType;
use App\Models\Submission;
use App\Repository\StudentRepository;

class Home extends Component
{
    public function render()
    {
        if (auth()->user()->role == UserType::student->name)
            return $this->studentView();
        elseif (auth()->user()->role == UserType::lecturer->name)
            return $this->lecturerView();
        elseif (auth()->user()->role == UserType::staff->name)
            return $this->staffView();
        else
            return $this->redirectRoute('logout');
    }

    public function studentView()
    {
        $student = StudentRepository::getStudent(auth()->user()->data->id);
        return view('pages.home.student', compact('student'))->title(__('Home'));
    }

    public function lecturerView()
    {
        $guidancesStudent = auth()->user()->data->students()->count();
        $studentsPassed = auth()->user()->data->students()->whereHas('passed')->count();
        $activeStudents = auth()->user()->data->students()->whereDoesntHave('passed')->count();
        $guidances = auth()->user()->data->students->sum(fn ($student) => $student->guidances->sum(fn ($guidance) => $guidance->submissions->count()));
        $revisions = auth()->user()->data->revisions()->count();
        $reviews = auth()->user()->data->reviews()->count();

        return view('pages.home.lecturer', [
            'guidancesStudent' => $guidancesStudent,
            'studentsPassed' => $studentsPassed,
            'activeStudents' => $activeStudents,
            'guidances' => $guidances,
            'revisions' => $revisions,
            'reviews' => $reviews
        ])->title(__('Home'));
    }

    public function staffView()
    {
        $allStudents = Student::count();
        $students = new Student();
        $allStudents = $students->replicate()->count();
        $studentsPassed = $students->replicate()->whereHas('passed')->count();
        $activeStudents = $students->replicate()->whereDoesntHave('passed')->count();
        $studentsNotRegistered = Register::count();
        $staff = Staff::count();
        $lecturers = Lecturer::count();
        $submissions = GuidanceSubmission::count();
        $waitingForApproval = Submission::having('status', SubmissionStatus::process->name)->groupBy('student_id')->count();
        $submissionsApproval = Submission::having('status', SubmissionStatus::approved->name)->groupBy('student_id')->count();
        $guidances = GuidanceSubmission::count();
        $guidance_groups = GuidanceGroup::count();
        $guidance_types = GuidanceType::count();

        return view('pages.home.staff', [
            'allStudents' => $allStudents,
            'studentsPassed' => $studentsPassed,
            'activeStudents' => $activeStudents,
            'studentsNotRegistered' => $studentsNotRegistered,
            'staff' => $staff,
            'lecturers' => $lecturers,
            'submissions' => $submissions,
            'guidances' => $guidances,
            'guidance_groups' => $guidance_groups,
            'guidance_types' => $guidance_types,
            'waitingForApproval' => $waitingForApproval,
            'submissionsApproval' => $submissionsApproval,
        ])->title(__('Home'));
    }
}
