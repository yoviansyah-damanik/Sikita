<?php

namespace App\Livewire\Revision;

use App\Enums\RevisionStatus;
use App\Models\Revision;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use LivewireAlert;

    protected $listeners = ['setCreateRevision'];

    public string $title;
    public string $explanation;

    public bool $isLoading = false;

    public $guidanceId;

    public function render()
    {
        return view('pages.revision.create');
    }

    public function rules()
    {
        return [
            'title' => 'required|string|between:10,200',
            'explanation' => 'nullable|string'
        ];
    }

    public function validationAttributes()
    {
        return [
            'title' => __('Title'),
            'explanation' => __('Explanation')
        ];
    }

    public function setCreateRevision($guidanceId)
    {
        $this->guidanceId = $guidanceId;
    }

    public function refresh()
    {
        $this->dispatch('clear-textarea');
        $this->reset('title');
    }

    public function store()
    {
        $this->validate();
        if (!$this->guidanceId) {
            return $this->alert('warning', __('Please choose guidance first.'));
        }
        try {
            Revision::create([
                'title' => $this->title,
                'explanation' => $this->explanation,
                'lecturer_id' => auth()->user()->data->id,
                'guidance_id' => $this->guidanceId,
                'status' => RevisionStatus::onProgress->name
            ]);

            $this->refresh();
            $this->dispatch('refreshRevision');
            $this->dispatch('toggle-create-revision-modal');
            $this->alert('success', __('Successfully'), ['text' => __(':attribute created successfully.', ['attribute' => __('Revision')])]);
        } catch (\Exception $e) {
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
            $this->isLoading = false;
        } catch (\Throwable $e) {
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
            $this->isLoading = false;
        }
    }
}
