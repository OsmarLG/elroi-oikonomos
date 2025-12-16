<div class="h-full flex flex-col gap-3">

    {{-- TITLE --}}
    <input
        type="text"
        wire:model.defer="note.title"
        wire:blur="save"
        placeholder="Sin título"
        class="text-2xl font-bold border-none focus:ring-0 px-2"
    />

    <div class="grid grid-cols-2 gap-4 flex-1">

        {{-- MARKDOWN --}}
        <textarea
            wire:model.defer="note.content"
            wire:blur="save"
            class="w-full h-full resize-none border rounded p-3 font-mono text-sm"
            placeholder="Escribe en Markdown..."
        ></textarea>

        {{-- PREVIEW --}}
        <div class="border rounded p-3 overflow-y-auto prose max-w-none">
            {!! \Illuminate\Support\Str::markdown($note->content ?? '') !!}
        </div>

    </div>
</div>
