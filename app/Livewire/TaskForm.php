<?php

namespace App\Livewire;

use App\Models\Task;
// use App\Models\User; 
use App\Models\Status;
// use App\Models\Tag;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;



class TaskForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
        ->schema([

            Forms\Components\Select::make('status_id') 
                ->relationship('status', 'name')
                ->options(function () {
                    return Status::where('name', '!=', 'Accepted')->where('name', '!=', 'Rejected')->pluck('name', 'id');
                })
                ->required(),

            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255),
            Forms\Components\RichEditor::make('description')
                ->required()
                ->maxLength(255),

            Forms\Components\Select::make('tags') 
                ->relationship('tags', 'name') 
                ->multiple(), 
        ])
            ->statePath('data')
            ->model(Task::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = Task::create($data);

        $this->form->model($record)->saveRelationships();

        Notification::make()
            ->success()
            ->title('Task has been created')
            ->seconds(5)
            ->send();
 
        $this->form->fill();
    }

    public function render(): View
    {
        return view('livewire.task-form');
    }
}