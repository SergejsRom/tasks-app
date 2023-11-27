<div>
    <form wire:submit="create" class="bg-white p-6 rounded-md shadow-sm">
        {{ $this->form }}

        <button type="submit" class="bg-green-600 text-white font-bold rounded-md px-3 py-2 tracking-tight mt-8">
            Create task
        </button>
    </form>

    <x-filament-actions::modals />
</div>
