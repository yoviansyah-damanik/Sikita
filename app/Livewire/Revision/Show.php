<?php

namespace App\Livewire\Revision;

use Livewire\Component;
use App\Models\Revision;

class Show extends Component
{
    protected $listeners = ['setShowRevision', 'clearModal'];

    public bool $isLoading = false;

    public Revision $revision;

    public function render()
    {
        return view('pages.revision.show');
    }

    public function setShowRevision(Revision $revision)
    {
        $this->isLoading = true;
        $this->dispatch('clear-textarea');
        $this->dispatch('set-explanation-textarea-value', $revision->explanation);
        $this->reset();
        $this->revision = $revision;
        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->reset();
    }
}
