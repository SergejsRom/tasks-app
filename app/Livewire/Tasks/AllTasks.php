<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use App\Models\User;
use App\Models\Status;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms\Components\RichEditor;




class AllTasks extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
    
        $table = $table
            ->query(Task::where('user_id', '=', auth()->user()->id))
            ->columns([
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('status.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->html(),
                Tables\Columns\TextColumn::make('tags.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                ->relationship('status', 'name'),
                Tables\Filters\SelectFilter::make('tags')
                ->relationship('tags', 'name'),
            ])
            ->actions([
                ViewAction::make()
                ->form([
                    Select::make('status_id') 
                        ->relationship('status', 'name')
                        ->required(),
                    
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    
                    RichEditor::make('description')
                    ->required()
                    ->maxLength(255),

                    Select::make('tags')
                    ->relationship('tags', 'name') 
                        ->multiple(),
        ]),

                EditAction::make()
                ->form([
                        Select::make('status_id') 
                        ->relationship('status', 'name')
                        ->options(function () {
                            return Status::where('name', '!=', 'Accepted')->where('name', '!=', 'Rejected')->pluck('name', 'id');
                        })
                        ->required(),

                        TextInput::make('title')
                        ->visible(function (Task $task): bool {
                            $visible = auth()->user()->email == $task->created_by;
                        return $visible;
                        })
                        ->required()
                        ->maxLength(255),

                        RichEditor::make('description')
                        ->visible(function (Task $task): bool {
                            $visible = auth()->user()->email == $task->created_by;
                        return $visible;
                        })
                        ->required()
                        ->maxLength(255),

                        Select::make('tags') 
                        ->visible(function (Task $task): bool {
                            $visible = auth()->user()->email == $task->created_by;
                        return $visible;
                        })
                        ->relationship('tags', 'name') 
                        ->multiple(), 
                    ]),
            DeleteAction::make()
            ->before(
                function (DeleteAction $action,Task $task) {
                    if (auth()->user()->email != $task->created_by) {
                      Notification::make()
                         ->title('Sorry, can not delete!')
                         ->body('Can not delete this task because it was assigned by admin.')
                         ->status('danger')
                         ->send();
                         $action->cancel();
                   }
                })
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ]);
            return $table;
    }

    public function render(): View
    {
        return view('livewire.tasks.all-tasks');
    }
}
