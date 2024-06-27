<?php

namespace App\Livewire\Guidance;

use Livewire\Component;
use App\Models\GuidanceSubmission;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ReviewStudentSubmission extends Component
{
    use LivewireAlert;
    protected $listeners = ['checkActiveSubmission'];
    public array $submission;
    public bool $isActive = false;
    public int $iteration;

    public function mount(array $submission, $activeId, ?int $iteration = null)
    {
        $this->submission = $submission;
        $this->checkActiveSubmission($activeId);
        $this->iteration = $iteration;
    }

    public function checkActiveSubmission($activeId)
    {
        $this->isActive = $this->submission['id'] == $activeId ? true : false;
    }

    public function render()
    {
        return view('pages.guidance.review-student-submission');
    }

    public function download()
    {
        try {
            return response()->download(
                $this->submission['fullStorageFile'],
                $this->submission['filename']
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

    public function setSubmission(string $submissionId)
    {
        $this->dispatch('setSubmission', $submissionId);
    }
}
