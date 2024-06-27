<?php

namespace App\Livewire\Guidance;

use App\Models\Student;
use Livewire\Component;
use App\Models\GuidanceGroup;
use Livewire\Attributes\Computed;
use App\Repository\StudentRepository;
use Livewire\Attributes\Url;

class Detail extends Component
{
    public $student;
    public $group;

    #[Computed, Url]
    public function groups()
    {
        return GuidanceGroup::get()
            ->map(fn ($group) => [
                'title' => $group->name,
                'value' => $group->id
            ])->toArray();
    }

    public function mount(Student $student)
    {
        $this->student = $student;
        $this->group = $this->groups[0]['value'];
    }

    public function render()
    {
        $studentData = StudentRepository::getStudent($this->student, $this->group);

        return view('pages.guidance.detail', compact('studentData'))
            ->title(__("Guidance's Detail"));
    }
}
