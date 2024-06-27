<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\GuidanceGroup;
use Livewire\Attributes\Computed;
use App\Repository\StudentRepository;

class Guidance extends Component
{
    protected $listeners = ['refreshGuidances' => '$refresh'];
    public int $group;

    #[Computed]
    public function groups()
    {
        return GuidanceGroup::get()
            ->map(fn ($group) => [
                'title' => $group->name,
                'value' => $group->id
            ])->toArray();
    }

    public function mount()
    {
        $this->group = $this->groups[0]['value'];
    }

    public function render()
    {
        $student = StudentRepository::getStudent(auth()->user()->data, $this->group);

        return view('pages.student.guidance', compact('student'))
            ->title(__('Guidance'));
    }
}
