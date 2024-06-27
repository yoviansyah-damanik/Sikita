<?php

namespace App\Livewire\Guidance;

use App\Models\Student;
use Livewire\Component;
use App\Models\Guidance;
use App\Repository\StudentRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Review extends Component
{
    use LivewireAlert;
    protected $listeners = ['setSubmission', 'setRevision'];
    public $guidance;
    public $activeSubmission;

    public array $studentData;
    public array $revisions;

    public string $type;
    public string $source;
    public string $review;

    public bool $isLoading = false;

    public function mount(Student $student, Guidance $guidance)
    {
        $this->guidance = $guidance;

        $student = StudentRepository::getStudent(student: $student, guidanceTypeId: $guidance->guidance_type_id);
        // ddd($student);
        $isSupervisor = collect($student['supervisors'])->some(fn ($supervisor) => $supervisor['nidn'] == auth()->user()->data->id);
        if (
            empty($student['final_project']) ||
            empty($student['final_project']['guidances']) ||
            empty($student['final_project']['guidances'][0]['types']) ||
            !$isSupervisor
        ) {
            session()->flash('alert', true);
            session()->flash('alert-type', 'warning');
            session()->flash('msg', __('A review cannot be carried out because you are not the student\'s supervisor.'));
            return $this->redirectRoute('lecturer.guidance.detail', $student['data']['npm']);
        }

        if (auth()->user()->role != 'lecturer')
            return $this->redirectRoute('home');

        $this->activeSubmission = $student['final_project']['guidances'][0]['types'][0]['submissions'][0];
        $this->studentData = $student;
        // ddd($this->studentData);
        $this->source = $this->activeSubmission['fullStorageFile'];
    }

    public function render()
    {
        return view('pages.guidance.review')
            ->title(__("Guidance's Review"));
    }

    public function setSubmission(string $submissionId)
    {
        $this->activeSubmission = collect($this->studentData['final_project']['guidances'][0]['types'][0]['submissions'])
            ->where('id', $submissionId)
            ->first();
        $this->source = $this->activeSubmission['fullStorageFile'];
        $this->dispatch('checkActiveSubmission', $submissionId);
    }

    public function setRevision($revisions)
    {
        $this->revisions = $revisions;
    }
}
