<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Repository\StudentRepository;
use Livewire\Attributes\Computed;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class FinalProject extends Component
{
    use LivewireAlert;

    #[Computed]
    public function groups()
    {
        return \App\Models\GuidanceGroup::all();
    }

    public function render()
    {
        $student = StudentRepository::getStudent(auth()->user()->data);
        // ddd($student);
        $recap = [
            [
                "title" => __(":total Total", ['total' => __("Guidance's Submission")]),
                "value" => collect($student['final_project']['guidances'])->sum(fn ($guidance) => collect($guidance['types'])->sum(fn ($type) => count($type['submissions'])))
            ],
            [
                "title" => __(":total Total", ['total' => __('Revisions')]),
                "value" => collect($student['final_project']['guidances'])->sum(fn ($guidance) => collect($guidance['types'])->sum(fn ($type) => !empty($type['revisions']['count']) ? $type['revisions']['count']['total'] : 0))
            ],
            [
                "title" => __(':status Status', ['status' => __('Overall')]),
                "value" => $student['status']['message']
            ],
            [
                "title" => __(':status Status', ['status' => __('User')]),
                "value" => !$student['user']['is_suspended'] ? __('Active') : __('Suspended')
            ],
            [
                "title" => __(':status Status', ['status' => __('Passed')]),
                "value" => $student['is_passed']['status'] ? __('Passed') : __('Not Yet Passed')
            ],
            [
                "title" => __('Grade'),
                "value" => $student['is_passed']['status'] ? $student['is_passed']['data']['grade'] : '-'
            ],
            [
                "title" => __('Grade in Numbers'),
                "value" => $student['is_passed']['status'] ? $student['is_passed']['data']['grade_number'] : '-'
            ],
        ];

        return view('pages.student.final-project', compact('student', 'recap'))
            ->title(__('Final Project'));
    }
}
