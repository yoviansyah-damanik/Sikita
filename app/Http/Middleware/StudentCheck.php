<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Enums\SubmissionStatus;
use Symfony\Component\HttpFoundation\Response;

class StudentCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->user()->data->submissions()->where('status', SubmissionStatus::approved->name)->count()) {
            session()->flash('alert', true);
            session()->flash('alert-type', 'warning');
            session()->flash('msg', __('No submissions have been approved yet. Please confirm your submission with the staff on duty.'));

            return to_route('student.submission');
        }

        if (!auth()->user()->data->supervisors()->count()) {
            session()->flash('alert', true);
            session()->flash('alert-type', 'warning');
            session()->flash('msg', __('No supervisors found. Please confirm with the staff to assign a supervisor.'));

            return to_route('home');
        }

        return $next($request);
    }
}
