<?php

namespace App\Livewire\Guidance;

use App\Models\Guidance;
use Livewire\Component;

class Show extends Component
{
    protected $listeners = ['refreshShowGuidance' => '$refresh', 'clearShowGuidance', 'setShowGuidance', 'createGuidance'];

    public $guidance;
    public $guidanceTypeId;
    public bool $canCreate = false;
    public bool $isShow = false;

    public function render()
    {
        return view('pages.guidance.show');
    }

    public function setShowGuidance($guidanceTypeId, $studentId = null, bool $canCreate = false)
    {
        $this->guidanceTypeId = $guidanceTypeId;
        $this->canCreate = $canCreate;

        $studentId = $studentId ? $studentId : auth()->user()->data->id;

        $guidance = Guidance::firstOrCreate([
            'guidance_type_id' => $guidanceTypeId,
            'student_id' => $studentId
        ], []);

        $this->guidance = $guidance;
        // ddd($guidance, $guidance->submissions, $guidanceTypeId);
        $this->isShow = true;
    }

    public function clearShowGuidance()
    {
        $this->reset();
    }

    public function createGuidance()
    {
        $this->dispatch('setCreateGuidance', $this->guidance);
    }
}
