<div class="container mx-auto py-8">
    <a href="{{ url('/admin/notes-workspace') }}" class="mb-4 inline-flex items-center text-primary-600 hover:text-primary-700">
        <x-heroicon-o-arrow-left class="w-5 h-5 mr-1" />
        Volver al Workspace
    </a>
    <div class="h-[calc(100vh-150px)]"> {{-- Adjust height based on header/footer --}}
        <livewire:note-editor
            :note-id="$note->id"
            wire:key="single-note-{{ $note->id }}"
        />
    </div>
</div>
