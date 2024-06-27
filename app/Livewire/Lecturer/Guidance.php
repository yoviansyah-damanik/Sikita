<?php

namespace App\Livewire\Lecturer;

use App\Repository\StudentRepository;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Guidance extends Component
{
    use WithPagination;
    #[Url]
    public string $search = '';

    public function render()
    {
        $students = StudentRepository::getAll(studentStatus: 'progress',  limit: 15, search: $this->search, searchColumns: ['name', 'id'], searchType: 'supervisor', passType: 'not_yet_passed');

        return view('pages.lecturer.guidance', compact('students'))
            ->title(__('Guidance'));
    }

    public function updated($attribute)
    {
        $this->resetPage();
    }

    // public function show()
    // {
    //     $this->dispatch();
    // }
}
