<?php

namespace App\Livewire\Submission;

use App\Models\Submission;
use Livewire\Component;

class Show extends Component
{
    protected $listeners = ['setShowSubmission', 'clearModal'];
    public Submission $submission;
    public bool $isLoading = true;

    public function render()
    {
        return view('pages.submission.show');
    }

    public function setShowSubmission(Submission $submission)
    {
        $this->reset();
        $this->isLoading = true;
        $this->submission = $submission;
        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->isLoading = true;
        $this->reset();
    }
}
