<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Helpers\DownloadHelper;

class Staff extends Component
{
    use WithPagination;
    protected $listeners = [
        'refreshStaff' => '$refresh',
        'refreshUserActivation' => '$refresh',
        'setSearch'
    ];

    #[Url]
    public string $search = '';

    public function render()
    {
        $staff = \App\Models\Staff::with('user')
            ->whereAny(['id', 'name'], 'like', $this->search . "%")
            ->paginate(15);

        return view('pages.staff.staff', compact('staff'))
            ->title(__('Staff'));
    }

    public function updated($attribute)
    {
        $this->resetPage();
    }

    public function setSearch($search)
    {
        $this->search = $search;
    }

    public function download()
    {
        try {
            $staff = \App\Models\Staff::all();

            if (!count($staff)) {
                $this->alert('error', __('No :data found.', ['data' => __('Staff')]));
                return;
            }

            $download = DownloadHelper::downloadPdf(
                'all-staff',
                [
                    'staff' => $staff,
                ],
                __(':data Data', ['data' => __('All Staff')]) . ' ' . \Carbon\Carbon::now()->year
            );

            if (is_string($download)) {
                $this->alert('warning', $download);
                return;
            }

            return $download;
        } catch (\Exception $e) {
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
        } catch (\Throwable $e) {
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
        }
    }
}
