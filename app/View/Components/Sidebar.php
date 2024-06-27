<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $menu_group = [
            [
                [
                    'title' => __('Home'),
                    'icon' => 'i-ph-fire',
                    'to' => route('home'),
                    'isActive' => request()->routeIs('home')
                ]
            ],
            // [
            //     [
            //         'title' => __('Student'),
            //         'icon' => 'i-ph-student',
            //         'to' => route('student'),
            //         'isActive' => request()->routeIs('student')
            //     ],
            //     [
            //         'title' => __('Lecturer'),
            //         'icon' => 'i-ph-chalkboard-teacher-fill',
            //         'to' => route('lecturer'),
            //         'isActive' => request()->routeIs('lecturer')
            //     ],
            //     [
            //         'title' => __('Staff'),
            //         'icon' => 'i-ph-lego-smiley',
            //         'to' => route('staff'),
            //         'isActive' => request()->routeIs('staff')
            //     ]
            // ],
            // [
            //     [
            //         'title' => __('Submission'),
            //         'icon' => 'i-ph-signature',
            //         'to' => route('submission'),
            //         'isActive' => request()->routeIs('submission')
            //     ],
            //     [
            //         'title' => __('Guidance'),
            //         'icon' => 'i-ph-book-open-text',
            //         'to' => route('guidance'),
            //         'isActive' => request()->routeIs('guidance')
            //     ]
            // ],
            // [
            //     [
            //         'title' => __('Account'),
            //         'icon' => 'i-ph-user',
            //         'to' => route('account'),
            //         'isActive' => request()->routeIs('account')
            //     ],
            // ],
            // [
            //     [
            //         'title' => __('Users'),
            //         'icon' => 'i-ph-users-three',
            //         'to' => route('users'),
            //         'isActive' => request()->routeIs('users')
            //     ],
            //     [
            //         'title' => __('Configuration'),
            //         'icon' => 'i-ph-gear-six',
            //         'to' => route('configuration'),
            //         'isActive' => request()->routeIs('configuration')
            //     ]
            // ]
        ];

        if (auth()->user()->role == 'staff') {
            $menu_group[] = [
                [
                    'title' => __('Student'),
                    'icon' => 'i-ph-student',
                    'to' => route('staff.student'),
                    'isActive' => request()->routeIs('staff.student')
                ],
                [
                    'title' => __('Lecturer'),
                    'icon' => 'i-ph-chalkboard-teacher-fill',
                    'to' => route('staff.lecturer'),
                    'isActive' => request()->routeIs('staff.lecturer')
                ],
                [
                    'title' => __('Staff'),
                    'icon' => 'i-ph-lego-smiley',
                    'to' => route('staff.staff'),
                    'isActive' => request()->routeIs('staff.staff')
                ],
            ];

            $menu_group[] = [
                [
                    'title' => __('Approval'),
                    'icon' => 'i-ph-signature',
                    'to' => route('staff.approval'),
                    'isActive' => request()->routeIs('staff.approval')
                ],
            ];

            $menu_group[] = [
                [
                    'title' => __('Guidance Group'),
                    'icon' => 'i-ph-list-checks',
                    'to' => route('staff.guidance-group'),
                    'isActive' => request()->routeIs('staff.guidance-group')
                ],
            ];
        } elseif (auth()->user()->role == 'student') {
            $menu_group[] = [
                [
                    'title' => __('Submission'),
                    'icon' => 'i-ph-signature',
                    'to' => route('student.submission'),
                    'isActive' => request()->routeIs('student.submission')
                ],
                [
                    'title' => __('Final Project'),
                    'icon' => 'i-ph-bookmarks-simple',
                    'to' => route('student.final-project'),
                    'isActive' => request()->routeIs('student.final-project')
                ],
                [
                    'title' => __('Guidance'),
                    'icon' => 'i-ph-book-open-text',
                    'to' => route('student.guidance'),
                    'isActive' => request()->routeIs('student.guidance')
                ],
            ];
        } else {
            $menu_group[] = [
                [
                    'title' => __('Guidance\'s Student'),
                    'icon' => 'i-ph-student',
                    'to' => route('lecturer.student'),
                    'isActive' => request()->routeIs('lecturer.student')
                ],
                [
                    'title' => __('Guidance'),
                    'icon' => 'i-ph-book-open-text',
                    'to' => route('lecturer.guidance'),
                    'isActive' => request()->routeIs('lecturer.guidance*')
                ],
            ];
        }

        if (auth()->user()->role == 'staff')
            $menu_group[] = [
                [
                    'title' => __('Users'),
                    'icon' => 'i-ph-users-three',
                    'to' => route('users'),
                    'isActive' => request()->routeIs('users')
                ],
                [
                    'title' => __('Report'),
                    'icon' => 'i-ph-newspaper',
                    'to' => route('report'),
                    'isActive' => request()->routeIs('report')
                ],
                [
                    'title' => __('Configuration'),
                    'icon' => 'i-ph-wrench',
                    'to' => route('configuration'),
                    'isActive' => request()->routeIs('configuration')
                ],
            ];

        $menu_group[] = [
            [
                'title' => __('Account'),
                'icon' => 'i-ph-user',
                'to' => route('account'),
                'isActive' => request()->routeIs('account')
            ],
        ];

        return view('components.sidebar', compact('menu_group'));
    }
}
