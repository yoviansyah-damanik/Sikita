<?php

namespace App\Livewire\Student;

use App\Enums\SupervisorType;
use App\Helpers\WaHelper;
use App\Jobs\WaSender;
use App\Models\Student;
use Livewire\Component;
use App\Models\Lecturer;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AssignSupervisors extends Component
{
    use LivewireAlert;
    protected $listeners = ['setAssignSupervisors', 'clearModal'];

    public $lecturers;
    public ?Student $student = null;
    public bool $isLoading = true;
    public $supervisor_1;
    public $supervisor_2;
    public $selected_supervisor_1;
    public $selected_supervisor_2;

    public function render()
    {
        return view('pages.student.assign-supervisors');
    }

    public function setSupervisors()
    {
        $this->supervisor_1 = Lecturer::whereHas('user', fn ($q) => $q->where('is_suspended', false))
            ->get()
            ->map(fn ($supervisor) => ['value' => $supervisor->id, 'title' => $supervisor->id . " | " . $supervisor->name])
            ->toArray();
        $this->selected_supervisor_1 = $this->student->supervisorsThrough->count() ? $this->student->supervisorsThrough->where('as', SupervisorType::supervisor_1->name)->first()->lecturer_id : (!empty($this->supervisor_1[0]['value']) ? $this->supervisor_1[0]['value'] : null);

        $this->supervisor_2 = Lecturer::whereHas('user', fn ($q) => $q->where('is_suspended', false))
            ->get()
            ->map(fn ($supervisor) => ['value' => $supervisor->id, 'title' => $supervisor->id . " | " . $supervisor->name])
            ->toArray();
        $this->selected_supervisor_2 = $this->student->supervisorsThrough->count() ? $this->student->supervisorsThrough->where('as', SupervisorType::supervisor_2->name)->first()->lecturer_id : (!empty($this->supervisor_2[0]['value']) ? $this->supervisor_2[0]['value'] : null);
    }

    public function setAssignSupervisors(Student $student)
    {
        $this->isLoading = true;
        $this->reset();
        $this->student = $student->load('supervisorsThrough', 'supervisors');
        $this->setSupervisors();
        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->reset();
        $this->isLoading = true;
    }

    public function rules()
    {
        return [
            'selected_supervisor_1' => [
                'required',
                'different:selected_supervisor_2',
                Rule::in(collect($this->supervisor_1)->pluck('value'))
            ],
            'selected_supervisor_2' => [
                'required',
                'different:selected_supervisor_1',
                Rule::in(collect($this->supervisor_2)->pluck('value')),
            ],
        ];
    }

    public function validationAttributes()
    {
        return [
            'selected_supervisor_1' => __('Supervisor :1', ['1' => 1]),
            'selected_supervisor_2' => __('Supervisor :1', ['1' => 2]),
        ];
    }

    public function save()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            $this->student->supervisorsThrough()->delete();

            $this->student->supervisorsThrough()->create([
                'lecturer_id' => $this->selected_supervisor_1,
                'as' => SupervisorType::supervisor_1->name
            ]);

            $this->student->supervisorsThrough()->create([
                'lecturer_id' => $this->selected_supervisor_2,
                'as' => SupervisorType::supervisor_2->name
            ]);

            $this->student->refresh();
            foreach ($this->student->supervisors as $idx => $supervisor) {
                WaSender::dispatch(
                    WaHelper::getTemplate('assign_supervisors', [
                        'lecturer_name' => $supervisor->name,
                        'as' => __('Supervisor :1', ['1' => $idx + 1]),
                        'npm' => $this->student->id,
                        'name' => $this->student->name
                    ]),
                    $supervisor->phone_number
                );
            }

            WaSender::dispatch(
                WaHelper::getTemplate('assign_supervisors_student', [
                    'nidn_1' => $this->student->supervisors[0]->id,
                    'name_1' => $this->student->supervisors[0]->name,
                    'nidn_2' => $this->student->supervisors[1]->id,
                    'name_2' => $this->student->supervisors[1]->name,
                ]),
                $this->student->phone_number
            );

            $this->isLoading = false;
            DB::commit();
            $this->dispatch('refreshStudents');
            $this->dispatch('toggle-assign-supervisors-modal');
            $this->alert('success', __('Successfully'), ['text' => __(':attribute updated successfully.', ['attribute' => __('Student')])]);
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
