<?php

namespace App\Livewire\Guidance;

use App\Jobs\WaSender;
use Livewire\Component;
use App\Helpers\WaHelper;
use Illuminate\Support\Str;
use App\Enums\GuidanceStatus;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Helpers\NotificationHelper;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CreateReview extends Component
{
    use LivewireAlert;

    public array $allStatus;
    public array $student;
    public array $finalProject;

    public string $status;
    public string $review;
    public string $action_time;

    public $guidance;

    public bool $isLoading = false;
    public bool $isFinish;

    public function mount($guidance, array $student, array $finalProject, bool $isFinish = false)
    {
        $this->isFinish = $isFinish;
        $this->guidance = $guidance;
        $this->student = $student;
        $this->finalProject = $finalProject;
        $this->allStatus = ['approved', 'revision'];
        $this->refresh();
    }

    public function refresh()
    {
        $review = $this->guidance->refresh()->reviews()->owned()->first();
        $this->review = $review ? $review->review : '';
        $this->status = $review ? $review->status : 'approved';
        $this->action_time = $review ? $review->updated_at->translatedFormat('d F Y H:i:s') : '-';
    }

    public function render()
    {
        return view('pages.guidance.create-review');
    }

    public function rules()
    {
        return [
            'status' => [
                'required',
                Rule::in($this->allStatus)
            ],
            'review' => 'required|string:between:10,400'
        ];
    }

    public function validationAttributes()
    {
        return [
            'status' => __('Status'),
            'review' => __('Review')
        ];
    }

    public function submit()
    {
        $this->validate();
        $this->isLoading = true;
        try {
            // $revisions = $this->guidance->refresh()->revisions->where('lecturer_id', auth()->user()->data->id);

            // if ($this->type == GuidanceStatus::finish->name && $revisions->count() > 0) {
            //     $this->alert('warning', 'Ooopppsss...', ['text' => __('There are still revisions to this guidance. Complete it first to confirm this guidance.')]);
            //     return;
            // }

            $this->guidance->histories()->create([
                'message' => __('Your supervisor (:lecturer) has carried out a review.', ['lecturer' => auth()->user()->data->name]),
                'type' => 'success'
            ]);

            $this->guidance->reviews()->updateOrCreate([
                'lecturer_id' => auth()->user()->data->id
            ], [
                'review' => $this->review,
                'status' => $this->status,
            ]);

            NotificationHelper::updateReview($this->finalProject['name'] . ' - ' . $this->finalProject['types'][0]['name'], $this->student);

            WaSender::dispatch(
                WaHelper::getTemplate('create_review', [
                    'nidn' => auth()->user()->data->id,
                    'lecturer' => auth()->user()->data->name,
                    'guidance_group' => $this->guidance->group->name,
                    'guidance_type' => $this->guidance->type->name,
                    'review_status' => __(Str::ucfirst($this->status)),
                    'review_message' => $this->review,
                    'review_time' => \Carbon\Carbon::now()->translatedFormat('d F Y H:i:s')
                ]),
                $this->guidance->student->phone_number
            );

            $this->refresh();
            $this->alert('success', __(':attribute updated successfully.', ['attribute' => __('Review')]));
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
