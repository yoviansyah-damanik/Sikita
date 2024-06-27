<?php

namespace App\Livewire\Revision;

use Livewire\Component;
use App\Models\Revision;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Edit extends Component
{
    use LivewireAlert;

    protected $listeners = ['setEditRevision', 'clearModal'];

    public string $title;
    public string $explanation;

    public bool $isLoading = false;

    public Revision $revision;

    public function render()
    {
        return view('pages.revision.edit');
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

    public function clearModal()
    {
        $this->dispatch('clear-textarea');
        $this->reset();
    }

    public function setEditRevision(Revision $revision)
    {
        $this->isLoading = true;
        $this->dispatch('clear-textarea');
        $this->dispatch('set-explanation-textarea-value', $revision->explanation);
        $this->reset('title', 'revision');
        $this->revision = $revision;
        $this->title = $revision->title;
        $this->explanation = $revision->explanation;
        $this->isLoading = false;
    }

    public function update()
    {
        $this->validate();

        if (!$this->revision) {
            return $this->alert('warning', __('Please choose :item first.', ['item' => Str::lower(__('Revision'))]));
        }

        try {
            $this->revision->update([
                'title' => $this->title,
                'explanation' => $this->explanation,
            ]);

            $this->dispatch('refreshRevision');
            $this->dispatch('toggle-edit-revision-modal');
            $this->alert('success', __('Successfully'), ['text' => __(':attribute updated successfully.', ['attribute' => __('Revision')])]);
        } catch (\Exception $e) {
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
            $this->isLoading = false;
        } catch (\Throwable $e) {
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
            $this->isLoading = false;
        }
    }
}
