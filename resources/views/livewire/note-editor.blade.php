<div class="h-full flex flex-col gap-3">

    {{-- Note Title Input --}}
    <input
        type="text"
        wire:model.defer="note.title"
        wire:blur="saveNoteTitleFromEditor"
        wire:keydown.enter="saveNoteTitleFromEditor"
        class="text-2xl font-bold border-none focus:ring-0 px-2 py-1 bg-transparent"
    />

    <div class="mb-2 px-2 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400" x-data="{ open: false }" @click.away="open = false">
        <label>Carpeta actual:</label>
        <div class="flex-1">
            <button type="button" @click="open = !open" class="flex items-center gap-1 text-primary-600 hover:text-primary-700 cursor-pointer">
                <span>{{ $this->note->folder->name ?? 'Sin carpeta' }}</span>
                <x-heroicon-o-pencil class="w-4 h-4" />
            </button>
            <div x-show="open" x-transition.origin.top-left.duration.200ms
                 class="absolute z-10 w-64 mt-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-gray-700">
                <select wire:model.live="note.folder_id" wire:change="saveNoteFolder($event.target.value)"
                        id="folder_id"
                        class="block w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500
                               dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200"
                        @click.outside="open = false" x-ref="selectFolder">
                    @foreach ($this->availableFolders as $folder)
                        <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Tags Section --}}
    <div class="mb-2 px-2">
        <div class="flex flex-wrap gap-1 mb-2">
            @foreach ($this->tags as $tag)
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-700 dark:bg-primary-600 dark:text-primary-100">
                    {{ $tag }}
                    <button type="button" wire:click="removeTag('{{ $tag }}')" class="ml-1 -mr-0.5 h-3 w-3 text-primary-500 hover:text-primary-700 dark:text-primary-200 dark:hover:text-primary-50">
                        <x-heroicon-o-x-mark class="w-3 h-3" />
                    </button>
                </span>
            @endforeach
        </div>
        <input
            type="text"
            wire:model.live.debounce.300ms="newTag"
            wire:keydown.enter="addTag"
            placeholder="Añadir etiqueta (Enter)"
            class="block w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500
                   dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200"
        />
        @error('newTag') <span class="text-danger-500 text-xs mt-1">{{ $message }}</span> @enderror
        {{-- Tag suggestions could go here (Alpine.js + Livewire computed property) --}}
    </div>

    <form wire:submit="saveForm" class="flex-1 flex flex-col gap-3">
        {{ $this->form }}
        <div class="flex justify-end">
            <x-filament::button type="submit">
                Guardar Contenido
            </x-filament::button>
        </div>
    </form>

</div>
