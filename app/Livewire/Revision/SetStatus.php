<?php

namespace App\Livewire\Revision;

use Livewire\Component;
use App\Models\Revision;
use App\Enums\RevisionStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class SetStatus extends Component
{
    use LivewireAlert;
    protected $listeners = ['setRevisionStatus', 'clearModal'];

    public bool $isLoading = true;
    public ?Revision $revision = null;
    public array $revisionTypes;
    public string $status;

    public function mount()
    {
        $this->revisionTypes = RevisionStatus::names();
    }

    public function render()
    {
        return view('pages.revision.set-status');
    }

    public function rules()
    {
        return [
            'status' => ['required', Rule::in($this->revisionTypes)],
        ];
    }

    public function validationAttributes()
    {
        return [
            'status' => __('Status')
        ];
    }

    public function clearModal()
    {
        $this->reset('status', 'revision');
        $this->isLoading = true;
    }

    public function setRevisionStatus(Revision $revision)
    {
        $this->clearModal();
        $this->revision = $revision;
        $this->status = $revision->status;
        $this->isLoading = false;
    }

    public function save()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            $this->revision->update([
                'status' => $this->status
            ]);

            $this->isLoading = false;
            DB::commit();
            $this->dispatch('refreshRevision');
            $this->dispatch('toggle-set-revision-status-modal');
            $this->alert('success', __('Successfully'), ['text' => __(':attribute updated successfully.', ['attribute' => __('Revision')])]);
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
