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
        NewTaskEmailEvent::class => [
            SendNewTaskEmailListener::class,
        ]

    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Task::creating(function($task){
            $task->created_by = auth()->id();
            if (auth()->user()->hasRole('super_admin')) {
                event( new NewTaskEmailEvent(event('email')));
            }
            });

        Task::updating(function($task){
                $task->created_by = auth()->id();
                });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
