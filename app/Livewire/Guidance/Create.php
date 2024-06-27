<?php

namespace App\Livewire\Guidance;

use App\Helpers\NotificationHelper;
use App\Helpers\WaHelper;
use App\Jobs\WaSender;
use Livewire\Component;
use App\Models\Guidance;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use WithFileUploads, LivewireAlert;

    const MAXFILE = 5 * 1024; // 5Mb
    const PATH = 'guidances';

    protected $listeners = ['setCreateGuidance'];
    public bool $isLoading = true;
    public $guidance;

    public $file;
    public string $title;
    public string $description;

    public function render()
    {
        return view('pages.guidance.create');
    }

    public function rules()
    {
        return [
            'file' => 'required|file|mimes:pdf|max:' . self::MAXFILE,
            'title' => 'required|string|between:10,200',
            'description' => 'required|string|between:10,200'
        ];
    }

    public function validationAttributes()
    {
        return [
            'file' => __('File'),
            'title' => __('Title'),
            'description' => __('Description')
        ];
    }
    public function setCreateGuidance(Guidance $guidance)
    {
        $this->resetValidation();
        $this->guidance = $guidance->load('type', 'group');
        $this->isLoading = false;
    }

    public function store()
    {
        $this->validate();
        $this->isLoading = true;
        DB::beginTransaction();

        $filename = base64_encode('guidance-' . $this->guidance->id . '-' . $this->guidance->submissions->count() + 1) . ".pdf";
        try {
            $filepath = $this->file->storePubliclyAs(path: self::PATH, name: $filename);

            $submission = $this->guidance->submissions()->create([
                'title' => $this->title,
                'filename' => $filename,
                'filepath' => $filepath,
                'description' => $this->description
            ]);

            $this->guidance->histories()->create([
                'message' => __('Submit guidance with the title :title.', ['title' => $this->title]),
                'type' => 'success'
            ]);

            NotificationHelper::storeGuidance($this->guidance, $submission);

            WaSender::dispatch(
                WaHelper::getTemplate('create_guidances_submission', [
                    'npm' => auth()->user()->data->id,
                    'name' => auth()->user()->data->name,
                    'guidance_group' => $this->guidance->group->name,
                    'guidance_type' => $this->guidance->type->name,
                    'title' => $this->title,
                    'link' => route('lecturer.guidance.review', ['student' => auth()->user()->data->id, 'guidance' => $this->guidance->id])
                ]),
                auth()->user()->data->supervisors()->pluck('phone_number')->toArray()
            );

            $this->dispatch('refreshGuidances');
            $this->dispatch('refreshShowGuidance');
            $this->dispatch('toggle-create-guidance-modal');
            $this->alert('success', __('Successfully'), ['text' => __(':attribute created successfully.', ['attribute' => __('Guidance')])]);

            DB::commit();
            $this->reset();
        } catch (\Exception $e) {
            if (Storage::exists(self::PATH . '/' . $filename))
                Storage::delete(self::PATH . '/' . $filename);

            DB::rollBack();
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
            $this->isLoading = false;
        } catch (\Throwable $e) {
            if (Storage::exists(self::PATH . '/' . $filename))
                Storage::delete(self::PATH . '/' . $filename);

            DB::rollBack();
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
            $this->isLoading = false;
        }
    }

    public function refresh()
    {
        $this->reset('title', 'file', 'description');
    }
}
