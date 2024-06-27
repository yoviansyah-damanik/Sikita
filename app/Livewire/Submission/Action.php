<?php

namespace App\Livewire\Submission;

use App\Jobs\WaSender;
use Livewire\Component;
use App\Helpers\WaHelper;
use App\Models\Submission;
use Illuminate\Support\Str;
use App\Enums\SubmissionStatus;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Helpers\NotificationHelper;
use App\Enums\SubmissionHistoryStatus;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Action extends Component
{
    use LivewireAlert;
    protected $listeners = ['setActionSubmission', 'clearModal'];

    public Submission $submission;
    public bool $isLoading = true;
    public array $types = ['approved', 'reject', 'revision'];
    public string $type = 'approved';
    public string $revisionText;

    public function render()
    {
        return view('pages.submission.action');
    }

    public function rules()
    {
        $rules = [
            'type' => [
                'required',
                Rule::in($this->types)
            ],
        ];

        if ($this->type == 'revision') {
            $rules['revisionText'] = 'required|string|between:10,300';
        }

        return $rules;
    }

    public function validationAttributes()
    {
        return [
            'type' => __('Type'),
            'revisionText' => __('Revision')
        ];
    }

    public function setActionSubmission(Submission $submission)
    {
        $this->submission = $submission;
        $this->isLoading = false;
    }

    public function submit()
    {
        $this->validate();
        $this->isLoading = true;
        DB::beginTransaction();
        try {
            if ($this->type == 'approved') {
                $this->submission->student->submissions()->where('id', '!=', $this->submission->id)->update(
                    [
                        'status' => SubmissionStatus::rejected->name
                    ]
                );

                $this->submission->update(
                    [
                        'status' => SubmissionStatus::approved->name
                    ]
                );

                $this->submission
                    ->histories()
                    ->create([
                        'message' => __('Submission has been approved.'),
                        'status' => SubmissionHistoryStatus::success->name
                    ]);

                NotificationHelper::approveSubmission($this->submission);
            } elseif ($this->type == 'reject') {
                $this->submission->update(
                    [
                        'status' => SubmissionStatus::rejected->name
                    ]
                );

                $this->submission
                    ->histories()
                    ->create([
                        'message' => __('Submission has been rejected.'),
                        'status' => SubmissionHistoryStatus::warning->name
                    ]);

                NotificationHelper::rejectSubmission($this->submission);
            } elseif ($this->type == 'revision') {
                $this->submission->update(
                    [
                        'status' => SubmissionStatus::revision->name
                    ]
                );

                $this->submission
                    ->histories()
                    ->create([
                        'message' => $this->revisionText,
                        'status' => SubmissionHistoryStatus::warning->name
                    ]);
                NotificationHelper::revisionSubmission($this->submission);
            } else
                $this->alert('warning', __('Mau ngapain hayoooo!'));

            WaSender::dispatch(
                WaHelper::getTemplate('submission_action', [
                    'title' => $this->submission->title,
                    'status' => __(Str::ucfirst($this->type)),
                    'message' => $this->type == 'revision' ? $this->revisionText : '-'
                ]),
                $this->submission->student->phone_number
            );

            $this->dispatch('refreshApproval');
            $this->dispatch('toggle-action-submission-modal');

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

    public function clearModal()
    {
        $this->reset();
    }
}
