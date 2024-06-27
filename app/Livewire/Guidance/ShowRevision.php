<?php

namespace App\Livewire\Guidance;

use Livewire\Component;
use App\Models\Guidance;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class ShowRevision extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $guidance;
    protected $listeners = ['setShowGuidancesRevision', 'clearModal'];

    public bool $isLoading = true;

    public function setRevisions()
    {
        return $this->guidance?->revisions()->paginate(5);
    }

    public function render()
    {
        $revisions = $this->setRevisions();
        return view('pages.guidance.show-revision', compact('revisions'));
    }

    public function setShowGuidancesRevision(Guidance $guidance)
    {
        $this->isLoading = true;
        $this->reset();
        $this->guidance = $guidance;
        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->isLoading = true;
        $this->reset();
    }
}
