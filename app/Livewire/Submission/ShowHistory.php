<?php

namespace App\Livewire\Submission;

use Livewire\Component;
use App\Models\Submission;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Livewire\WithoutUrlPagination;

class ShowHistory extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $listeners = ['setShowSubmissionHistory', 'clearModal'];
    public $submission;
    public bool $isLoading = true;

    public function setHistories()
    {
        return $this->submission?->histories()->paginate(10);
    }

    public function render()
    {
        $histories = $this->setHistories();
        return view('pages.submission.show-history', compact('histories'));
    }

    public function setShowSubmissionHistory(Submission $submission)
    {
        $this->isLoading = true;
        $this->reset();
        $this->submission = $submission;
        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->isLoading = true;
        $this->reset();
    }
}
