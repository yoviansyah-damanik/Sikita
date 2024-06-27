<?php

namespace App\Livewire;

use Livewire\Component;

class ViewPdfModal extends Component
{
    protected $listeners = ['setSource', 'clearModal'];

    public bool $isLoading = true;
    public string $source;

    public function render()
    {
        return view('pages.view-pdf-modal');
    }

    public function setSource($source)
    {
        $this->source = $source;
        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->isLoading = true;
        $this->reset();
    }
}
