<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\PDF;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class GuidanceJourney extends Component
{
    use LivewireAlert;
    public array $student;
    public bool $isLoading = false;

    public function mount($student)
    {
        $this->student = $student;
        // ddd($student);
    }

    public function render()
    {
        return view('pages.student.guidance-journey');
    }

    public function print()
    {
        $this->isLoading  = true;
        try {
            $pdf = PDF::loadView('print.guidance-journey', ['student' => $this->student])
                ->setPaper('A4', 'portrait')
                ->output();

            $this->isLoading = false;

            return response()->streamDownload(
                function () use ($pdf) {
                    print($pdf);
                },
                $this->student['data']['npm'] . "_" . Str::replace(' ', '_', $this->student['data']['name'] . ' ' . __('Guidance Completion Mark')) . '.pdf'
            );
        } catch (\Exception $e) {
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
            $this->isLoading = false;
        } catch (\Throwable $e) {
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
            $this->isLoading = false;
        }
    }
}
