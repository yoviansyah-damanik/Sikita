<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Repository\StudentRepository;

class Approval extends Component
{
    use WithPagination;
    protected $listeners = ['refreshApproval' => '$refresh'];

    #[Url]
    public string $search = '';

    public int $limit = 15;

    public function rendered()
    {
        if (request()->submissionId) {
            $this->dispatch('toggle-show-submission-modal');
            $this->showSubmission(request()->submissionId);
        }
    }

    public function render()
    {
        $students = StudentRepository::getAll(searchColumns: ['id', 'name'], search: $this->search, limit: $this->limit, searchType: 'approval');

        return view('pages.staff.approval', compact('students'))
            ->title(__('Approval'));
    }

    public function updated($attribute)
    {
        $this->resetPage();
    }

    public function showStudent($student)
    {
        $this->dispatch('setStudent', $student);
    }

    public function showSubmission($submissionId)
    {
        $this->dispatch('setShowSubmission', $submissionId);
    }

    public function actionSubmission($submissionId)
    {
        $this->dispatch('setActionSubmission', $submissionId);
    }
}
