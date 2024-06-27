<?php

namespace App\Livewire\Staff;

use Livewire\Attributes\Computed;
use Livewire\Component;

class GuidanceGroup extends Component
{
    protected $listeners = ['refreshGroup' => '$refresh'];

    #[Computed]
    public function groups()
    {
        return \App\Models\GuidanceGroup::all();
    }

    public function render()
    {
        return view('pages.staff.guidance-group')
            ->title(__('Guidance Group'));
    }

    public function create()
    {
        $this->dispatch('setCreate');
    }

    public function edit($id)
    {
        $this->dispatch('setEdit', $id);
    }

    public function delete($id)
    {
        $this->dispatch('setDelete', $id);
    }

    public function createSub($parent_id)
    {
        $this->dispatch('setCreateSub', $parent_id);
    }

    public function editSub($id)
    {
        $this->dispatch('setEditSub', $id);
    }

    public function deleteSub($id)
    {
        $this->dispatch('setDeleteSub', $id);
    }
}
