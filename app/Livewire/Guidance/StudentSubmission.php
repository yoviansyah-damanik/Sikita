<?php

namespace App\Livewire\Guidance;

use Livewire\Component;
use App\Models\GuidanceSubmission;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class StudentSubmission extends Component
{
    use LivewireAlert;
    public GuidanceSubmission $submission;

    public function mount(GuidanceSubmission $submission)
    {
        $this->submission = $submission;
    }

    public function render()
    {
        return view('pages.guidance.student-submission');
    }

    public function download()
    {
        try {
            return response()->download(
                $this->submission->storageFile(isFull: true),
                $this->submission->filename
            );
        } catch (\Exception $e) {
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
        } catch (\Throwable $e) {
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
        }
    }

    public function showPdf($source)
    {
        $this->dispatch('setSource', $source);
    }
}
