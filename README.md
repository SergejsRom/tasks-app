
## Description

We need a task management app with the following requirements:

:white_check_mark: The app has two types of users, admin user and normal user.


:white_check_mark: Normal users can register and log in.

:white_check_mark: Admin users can log in to the admin panel and new admins are only allowed to create from the admin panel.

:white_check_mark: Each normal user can view, create, edit, and delete their tasks in the user panel.

:white_check_mark: Each task contains a title, a description, a status, and multiple tags.

:white_check_mark: Tasks can either be created by the normal user from the user panel or by admins from the admin panel and assigned to a normal user.

:white_check_mark: Normal users can change the title, text, status, and tags of tasks created by them but are not allowed to change the title, text, and tags of tasks created by admins. Normal users only can change the status of tasks created by admins.

:white_check_mark: Normal users can delete tasks created by them but are not allowed to delete tasks created by admins.

:white_check_mark: Each task has a status with the following values: Open, Pending, In-progress, In-review, Accepted, and Rejected.

:white_check_mark: Normal users can change each task status to Open, Pending, In-progress, or In-review but only admins are allowed to set task status as Accepted or Rejected from the admin panel.

:white_check_mark: Admins should be able to create tags from the admin panel but normal users only can select tags from the tags list defined by admins.

:white_check_mark: Admins must be able to filter tasks by assigned user, status, and tag in the admin panel.
Normal users must be able to filter their tasks by status or tags in the user panel.

:white_check_mark: When admins create a new task for a normal user, the user should receive an email to inform them they have a new task.

When a user changes a task status to In-review that was created by an admin, the admin that created the task should receive an email to notify them that the user has done the task and is ready for review.

### App created uing laravel, filamnetphp, livewire, jetstream, tailwindcss.
For the user reused filament with livewire component.\
For roles and permissions used filament shield and on top restricted access to filament admin panel in user model. (Could be done without shield, just with restrictions by role)\
Seeders for admin user and statuses
