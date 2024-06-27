<?php

namespace App\Livewire\Guidance;

use Livewire\Component;
use App\Models\Guidance;
use Illuminate\Support\Facades\DB;

class ReviewRevision extends Component
{
    protected $listeners = ['refreshRevision'];
    public $guidance;
    public bool $isFinish;

    public function mount(Guidance $guidance, bool $isFinish = false)
    {
        $this->isFinish = $isFinish;
        $this->guidance = $guidance->load('revisions', 'revisions.lecturer');
        // $this->guidance = $guidance;
    }

    public function render()
    {
        return view('pages.guidance.review-revision');
    }

    public function refreshRevision()
    {
        $this->guidance->refresh();
    }

    public function done()
    {
        DB::beginTransaction();
        try {
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
