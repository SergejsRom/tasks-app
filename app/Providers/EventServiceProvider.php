<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Models\Task;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Providers\Auth;
use App\Events\NewTaskEmailEvent;
use App\Listeners\SendNewTaskEmailListener;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewTaskEmail;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Task::creating(function($task){
            if (auth()->user()->hasRole('panel_user')) {
                $task->user_id = auth()->user()->id;
            }

            $task->created_by = auth()->user()->email;
            
            if (auth()->user()->hasRole('super_admin')) {
                event( new NewTaskEmailEvent(event($task->user->email)));
                Mail::to($task->user->email)->send(new NewTaskEmail());
            }
            });

        // Task::updating(function($task){
        //         $task->created_by = auth()->id();
        //         if (auth()->user()->hasRole('super_admin')) {
        //             event( new NewTaskEmailEvent(event($task->user->email)));
        //             Mail::to($task->user->email)->send(new NewTaskEmail());
        //         }
        //         });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
