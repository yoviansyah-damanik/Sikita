<?php

namespace App\Livewire\Guidance;

use Livewire\Component;
use App\Models\Guidance;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class ShowHistory extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $listeners = ['setShowGuidancesHistory', 'clearModal'];

    public $guidance;
    public bool $isLoading = true;

    public function setHistories()
    {
        return $this->guidance?->histories()->paginate(10);
    }

    public function render()
    {
        $histories = $this->setHistories();
        return view('pages.guidance.show-history', compact('histories'));
    }

    public function setShowGuidancesHistory(Guidance $guidance)
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
