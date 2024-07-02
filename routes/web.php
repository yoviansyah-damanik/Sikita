<?php

use Illuminate\Support\Facades\Route;

Route::middleware('guest')
    ->group(function () {
        Route::get('/login', App\Livewire\Auth\Login::class)
            ->name('login');
        Route::get('/register', App\Livewire\Auth\Register::class)
            ->name('register');
    });

Route::middleware('auth')
    ->group(function () {
        Route::get('/', \App\Livewire\Home::class)
            ->name('home');

        // STAFF ONLY
        Route::as('staff.')
            ->prefix('staff')
            ->middleware('userType:staff')
            ->group(function () {
                Route::get('/student', \App\Livewire\Staff\Student::class)
                    ->name('student');
                Route::get('/lecturer', \App\Livewire\Staff\Lecturer::class)
                    ->name('lecturer');
                Route::get('/staff', \App\Livewire\Staff\Staff::class)
                    ->name('staff');

                Route::get('/guidance-group', \App\Livewire\Staff\GuidanceGroup::class)
                    ->name('guidance-group');

                Route::get('/approval', \App\Livewire\Staff\Approval::class)
                    ->name('approval');
            });

        // STUDENT ONLY
        Route::as('student.')
            ->prefix('student')
            ->middleware('userType:student')
            ->group(function () {
                Route::get('/submission', \App\Livewire\Student\Submission::class)
                    ->name('submission');

                Route::get('/final-project', \App\Livewire\Student\FinalProject::class)
                    ->name('final-project')
                    ->middleware('studentCheck');

                Route::get('/guidance', \App\Livewire\Student\Guidance::class)
                    ->name('guidance')
                    ->middleware('studentCheck');
            });

        // LECTURER ONLY
        Route::as('lecturer.')
            ->prefix('lecturer')
            ->middleware('userType:lecturer')
            ->group(function () {
                Route::get('/student', \App\Livewire\Lecturer\Student::class)
                    ->name('student');
                Route::get('/guidance', \App\Livewire\Lecturer\Guidance::class)
                    ->name('guidance');
                Route::get('/guidance/{student:id}', \App\Livewire\Guidance\Detail::class)
                    ->name('guidance.detail');
                Route::get('/guidance/{student:id}/{guidance:id}', \App\Livewire\Guidance\Review::class)
                    ->name('guidance.review');
            });


        Route::get('/users', \App\Livewire\Users\Index::class)
            ->name('users');

        Route::get('/configuration', \App\Livewire\Configuration::class)
            ->name('configuration');

        Route::get('/account', \App\Livewire\Account\Index::class)
            ->name('account');

        Route::get('/logout', \App\Livewire\Auth\Logout::class)
            ->name('logout');
    });
