<?php

namespace App\Livewire\Submission;

use App\Models\Staff;
use App\Jobs\WaSender;
use Livewire\Component;
use App\Helpers\WaHelper;
use App\Models\Submission;
use Illuminate\Support\Str;
use Livewire\Attributes\Rule;
use App\Enums\SubmissionStatus;
use Illuminate\Support\Facades\DB;
use App\Helpers\NotificationHelper;
use App\Enums\SubmissionHistoryStatus;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use LivewireAlert;
    protected $listeners = ['setCreateSubmission', 'clearModal'];

    #[Rule('required|string|between:10,200')]
    public string $title;

    #[Rule('required|string|between:10,400')]
    public string $abstract;

    public bool $isLoading = true;

    public function render()
    {
        return view('pages.submission.create');
    }

    public function validationAttributes()
    {
        return [
            'title' => __('Title'),
            'abstract' => __('Abstract')
        ];
    }

    public function setCreateSubmission()
    {
        $this->isLoading = true;
        $this->resetValidation();
        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->reset();
        $this->resetValidation();
        $this->isLoading = true;
    }

    public function save()
    {
        $this->validate();
        $this->isLoading = true;
        DB::beginTransaction();
        try {
            if (
                auth()->user()->data->submissions()->where('status', SubmissionStatus::process->name)->count() >= Submission::MAX_SUBMISSIONS
                || auth()->user()->data->submissions()->where('status', SubmissionStatus::approved->name)->count() > 0
            ) {
                $this->alert('warning', __('Attention'), ['text' => __('Cannot add applications because there are already approved applications or up to 3 applications have been submitted. The maximum application limit is :max.', ['max' => Submission::MAX_SUBMISSIONS])]);
            } else {
                $submission = Submission::create([
                    'student_id' => auth()->user()->data->id,
                    'title' => $this->title,
                    'abstract' => $this->abstract,
                ]);

                $submission
                    ->histories()
                    ->create([
                        'message' => __('Submissions with the title ":title" are currently in the process of being examined by staff.', ['title' => $this->title]),
                        'status' => SubmissionHistoryStatus::information->name
                    ]);

                NotificationHelper::storeSubmission($submission);

                WaSender::dispatch(
                    WaHelper::getTemplate('create_submission', [
                        'npm' => auth()->user()->data->id,
                        'name' => auth()->user()->data->name,
                        'title' => $this->title,
                        'abstract' => Str::limit($this->abstract, 100),
                    ]),
                    Staff::all()->pluck('phone_number')->toArray()
                );
                DB::commit();
                $this->reset();
                $this->dispatch('refreshSubmission');
                $this->dispatch('toggle-create-modal');
                $this->alert('success', __('Successfully'), ['text' => __(':attribute created successfully.', ['attribute' => __('Submission')])]);
            }
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
