<x-filament-panels::page>

    <div class="grid grid-cols-12 h-[80vh] gap-0">

        {{-- =========================
            FOLDERS SIDEBAR
        ========================= --}}
        <aside class="col-span-2 border-r bg-white dark:bg-gray-900 px-3 py-4 space-y-2">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-semibold">Carpetas</span>

                <x-filament::icon-button
                    icon="heroicon-o-folder-plus"
                    size="sm"
                    wire:click="createFolder"
                />
            </div>

            @forelse ($this->folders as $folder)
                <button
                    wire:click="selectFolder({{ $folder->id }})"
                    class="w-full text-left px-2 py-1 rounded text-sm
                        {{ $selectedFolder === $folder->id
                            ? 'bg-primary text-white'
                            : 'hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                    📁 {{ $folder->name }}
                </button>
            @empty
                <p class="text-xs text-gray-400">Sin carpetas</p>
            @endforelse
        </aside>

        {{-- =========================
            NOTES LIST
        ========================= --}}
        <section class="col-span-3 border-r bg-gray-50 dark:bg-gray-800 px-3 py-4 space-y-2">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-semibold">Notas</span>

                <x-filament::icon-button
                    icon="heroicon-o-plus"
                    size="sm"
                    wire:click="createNote"
                />
            </div>

            @forelse ($this->notes as $note)
                <button
                    wire:click="selectNote({{ $note->id }})"
                    class="w-full text-left px-2 py-2 rounded text-sm
                        {{ $selectedNote === $note->id
                            ? 'bg-gray-200 dark:bg-gray-700'
                            : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <div class="font-medium truncate">
                        {{ $note->title ?: 'Sin título' }}
                    </div>
                    <div class="text-xs text-gray-500">
                        {{ $note->updated_at->diffForHumans() }}
                    </div>
                </button>
            @empty
                <p class="text-xs text-gray-400">No hay notas</p>
            @endforelse
        </section>

        {{-- =========================
            EDITOR
        ========================= --}}
        <section class="col-span-7 bg-white dark:bg-gray-900 p-4">
            @if ($selectedNote)
                <livewire:note-editor
                    :note-id="$selectedNote"
                    wire:key="note-{{ $selectedNote }}"
                />
            @else
                <div class="h-full flex items-center justify-center text-gray-400">
                    Selecciona o crea una nota
                </div>
            @endif
        </section>

    </div>

</x-filament-panels::page>
