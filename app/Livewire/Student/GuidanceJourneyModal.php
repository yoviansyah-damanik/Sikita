<?php

namespace App\Livewire\Student;

use App\Repository\StudentRepository;
use Livewire\Component;

class GuidanceJourneyModal extends Component
{
    public array $student = [];

    protected $listeners = ['setGuidanceJourney', 'clearModal'];

    public bool $isLoading = true;

    public function render()
    {
        return view('pages.student.guidance-journey-modal');
    }

    public function setGuidanceJourney(String $studentId)
    {
        $this->clearModal();
        $this->student = StudentRepository::getStudent($studentId);
        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->reset();
        $this->isLoading = true;
    }
}
