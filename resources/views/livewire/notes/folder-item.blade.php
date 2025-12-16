<div style="padding-left: {{ $level * 1.25 }}rem">
    <div
        class="group flex items-center justify-between px-2 py-1 rounded
        {{ $selectedFolderId === $folder->id ? 'bg-primary-500/10' : 'hover:bg-gray-100' }}">

        {{-- Select --}}
        <button
            wire:click="selectFolder({{ $folder->id }})"
            class="flex items-center gap-2 truncate flex-1 text-left">
            <x-heroicon-o-folder class="w-4 h-4 shrink-0" />
            <span class="truncate">{{ $folder->name }}</span>
        </button>

        {{-- Actions --}}
        @if ($folder->id > 0)
            <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition">

                {{-- Rename --}}
                <x-filament::icon-button
                    icon="heroicon-o-pencil"
                    size="xs"
                    wire:click.stop="$dispatch('mount-action', {
                        name: 'renameFolder',
                        arguments: { id: {{ $folder->id }} }
                    })"
                />

                {{-- Subfolder --}}
                <x-filament::icon-button
                    icon="heroicon-o-plus"
                    size="xs"
                    wire:click.stop="createSubFolder({{ $folder->id }})"
                />
            </div>
        @endif
    </div>

    @foreach ($folder->children as $child)
        @include('livewire.notes.folder-item', [
            'folder' => $child,
            'level' => $level + 1,
            'selectedFolderId' => $selectedFolderId,
        ])
    @endforeach
</div>
