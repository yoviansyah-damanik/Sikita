<?php

namespace App\Livewire\Submission;

use Livewire\Component;
use App\Models\Submission;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\DB;
use App\Helpers\NotificationHelper;
use App\Enums\SubmissionHistoryStatus;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Edit extends Component
{
    use LivewireAlert;
    protected $listeners = ['setEditSubmission', 'clearModal'];

    public Submission $submission;

    #[Rule('required|string|between:20,200')]
    public string $title;

    #[Rule('required|string|between:50,500')]
    public string $abstract;

    public bool $isLoading = true;

    public function render()
    {
        return view('pages.submission.edit');
    }

    public function validationAttributes()
    {
        return [
            'title' => __('Title'),
            'abstract' => __('Abstract')
        ];
    }

    public function setEditSubmission(Submission $submission)
    {
        $this->clearModal();
        $this->submission = $submission;
        $this->title = $submission->title;
        $this->abstract = $submission->abstract;
        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->isLoading = true;
        $this->reset();
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate();
        $this->isLoading = true;
        DB::beginTransaction();
        try {
            $columnsUpdate = [];
            if ($this->title != $this->submission->title)
                $columnsUpdate[] = __('Title');

            if ($this->abstract != $this->submission->abstract)
                $columnsUpdate[] = __('Abstract');

            $this->submission->update([
                'title' => $this->title,
                'abstract' => $this->abstract,
            ]);

            $this->submission->histories()->create([
                'message' => __('Update :update', ['update' => __('Submission')]) . ' - ' . join(', ', $columnsUpdate),
                'status' => SubmissionHistoryStatus::information->name
            ]);

            NotificationHelper::updateSubmission($this->submission);

            $this->dispatch('refreshSubmission');
            $this->dispatch('toggle-edit-modal');
            $this->alert('success', __('Successfully'), ['text' => __(':attribute updated successfully.', ['attribute' => __('Submission')])]);

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
