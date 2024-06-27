<?php

namespace App\Livewire\Submission;

use Livewire\Component;
use App\Models\Submission;
use Illuminate\Support\Facades\DB;
use App\Helpers\NotificationHelper;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Delete extends Component
{
    use LivewireAlert;
    protected $listeners = ['setDeleteSubmission', 'clearModal'];

    public Submission $submission;
    public bool $isLoading = true;

    public function render()
    {
        return view('pages.submission.delete');
    }

    public function setDeleteSubmission(Submission $submission)
    {
        $this->clearModal();
        $this->submission = $submission;
        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->reset();
        $this->resetValidation();
        $this->isLoading = true;
    }

    public function destroy()
    {
        $this->isLoading = true;
        DB::beginTransaction();
        try {
            $this->submission->histories()->delete();
            $this->submission->delete();

            NotificationHelper::deleteSubmission($this->submission);

            $this->dispatch('refreshSubmission');
            $this->dispatch('toggle-delete-modal');
            $this->alert('success', __('Successfully'), ['text' => __(':attribute deleted successfully.', ['attribute' => __('Submission')])]);

            DB::commit();
            $this->isLoading = false;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
            $this->isLoading = false;
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
            $this->isLoading = false;
        }
    }
}
