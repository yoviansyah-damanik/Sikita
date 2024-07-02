<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Helpers\DownloadHelper;
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
        try {
            $download = DownloadHelper::downloadPdf(
                'guidance-journey',
                [
                    'student' => $this->student,
                ],
                $this->student['data']['npm'] . "_" . Str::replace(' ', '_', $this->student['data']['name'] . ' ' . __('Guidance Completion Mark')),
                orientation: 'portrait'
            );

            if (is_string($download)) {
                $this->alert('warning', $download);
                return;
            }

            return $download;
        } catch (\Exception $e) {
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
        } catch (\Throwable $e) {
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
        }
    }
}
