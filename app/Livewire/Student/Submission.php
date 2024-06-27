<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\Attributes\Url;
use App\Repository\StudentRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Submission extends Component
{
    protected $listeners = ['refreshSubmission' => '$refresh'];

    #[Url]
    public string $search;

    public function render()
    {
        $student = StudentRepository::getStudent(auth()->user()->data);

        // ddd($student);
        return view('pages.student.submission', compact('student'))
            ->title(__('Submissions'));
    }

    public function edit($submission)
    {
        $this->dispatch('setEditSubmission', $submission);
    }

    public function delete($submission)
    {
        $this->dispatch('setDeleteSubmission', $submission);
    }

    public function show($submission)
    {
        $this->dispatch('setShowSubmission', $submission);
    }

    public function showHistory($submission)
    {
        $this->dispatch('setShowSubmissionHistory', $submission);
    }

    public function create()
    {
        $this->dispatch('setCreateSubmission');
    }
}
