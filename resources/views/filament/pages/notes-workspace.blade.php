<x-filament-panels::page>

    @if ($this->breadcrumbs->count())
        <ol class="flex items-center w-full gap-4 mb-6" aria-label="Breadcrumbs">
            @foreach ($this->breadcrumbs as $index => $crumb)
                <li class="flex items-center flex-1">

                    {{-- CÍRCULO --}}
                    <button wire:click="goToFolder({{ $crumb['id'] === null ? 'null' : $crumb['id'] }})"
                        class="flex items-center gap-2 group">

                        @if ($index < $this->breadcrumbs->count() - 1)
                            {{-- COMPLETADO --}}
                            <span
                                class="flex size-6 items-center justify-center rounded-full
               bg-primary text-on-primary text-sm font-bold">
                                ✓
                            </span>
                        @else
                            {{-- ACTUAL --}}
                            <span
                                class="flex size-4 items-center justify-center rounded-full
               bg-primary ring-4 ring-primary/20">
                            </span>
                        @endif

                        <span
                            class="text-sm
                        {{ $index === $this->breadcrumbs->count() - 1
                            ? 'font-semibold text-primary'
                            : 'text-on-surface hover:underline' }}">
                            {{ $crumb['label'] }}
                        </span>
                    </button>

                    {{-- LÍNEA (no para el último) --}}
                    @if (!$loop->last)
                        <span class="flex-1 h-px mx-4 bg-outline"></span>
                    @endif
                </li>
            @endforeach
        </ol>
    @endif

    {{-- =========================
        HEADER DINÁMICO
    ========================= --}}
    <div class="mb-4">
        @if ($selectedFolderId)
            <h3 class="text-base font-semibold text-on-surface-strong">
                Notas de:
                <span class="text-primary">
                    {{ $this->selectedFolder?->name }}
                </span>
            </h3>
        @else
            <h3 class="text-base font-semibold text-on-surface-strong">
                Notas recientes
            </h3>
        @endif
    </div>

    {{-- =========================
        NOTAS
    ========================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse ($selectedFolderId ? $this->notes : $this->lastNotes as $lnote)
            @php
                $initials = collect(explode(' ', $lnote->author->name))
                    ->filter()
                    ->take(2)
                    ->map(fn($n) => strtoupper(substr($n, 0, 1)))
                    ->join('');
            @endphp

            <article wire:click="selectNote({{ $lnote->id }})"
                class="group cursor-pointer rounded-md border border-outline
                       bg-surface-alt p-3 hover:shadow-sm transition
                       flex flex-col gap-2">

                {{-- Header --}}
                <div class="flex items-start gap-2">
                    <div class="flex items-center justify-center size-7 rounded-md bg-primary/10 text-primary">
                        <x-heroicon-o-document-text class="w-3.5 h-3.5" />
                    </div>

                    <div class="flex-1 min-w-0">
                        <h2 class="text-xs font-semibold truncate text-on-surface-strong">
                            {{ $lnote->title ?: 'Sin título' }}
                        </h2>

                        <p class="text-[11px] text-on-surface mt-0.5">
                            Carpeta:
                            <span class="font-medium">
                                {{ $lnote->folder?->name ?? 'Sin carpeta' }}
                            </span>
                        </p>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="flex items-center gap-2 mt-auto pt-2 border-t border-outline">
                    <div
                        class="flex items-center justify-center size-6 rounded-full
                               bg-primary text-on-primary text-[10px] font-semibold">
                        {{ $initials }}
                    </div>

                    <div class="leading-tight">
                        <span class="block text-[11px] font-medium text-on-surface-strong">
                            {{ $lnote->author->name }}
                        </span>
                        <span class="text-[10px] text-on-surface">
                            {{ $lnote->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
            </article>
        @empty
            <p class="text-sm text-on-surface col-span-full">
                No hay notas.
            </p>
        @endforelse
    </div>

    {{-- PAGINACIÓN SOLO CUANDO HAY CARPETA --}}
    @if ($selectedFolderId)
        <div class="mt-4">
            {{ $this->notes->links() }}
        </div>
    @endif

    {{-- =========================
        CARPETAS / SUBCARPETAS
    ========================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-8">
        <h2 class="text-base font-semibold text-on-surface-strong col-span-full">
            {{ $selectedFolderId ? 'Subcarpetas' : 'Carpetas' }}
        </h2>

        @php
            $foldersToShow = $selectedFolderId ? $this->selectedFolder?->children ?? collect() : $this->folders;
        @endphp

        @if (!$selectedFolderId)
            <article wire:click="selectFolder({{ \App\Filament\Pages\NotesWorkspace::ALL_NOTES }})"
                class="cursor-pointer rounded-md border border-outline p-3 bg-surface-alt">
                <strong>Todas las notas</strong>
            </article>

            <article wire:click="selectFolder({{ \App\Filament\Pages\NotesWorkspace::NO_FOLDER }})"
                class="cursor-pointer rounded-md border border-outline p-3 bg-surface-alt">
                <strong>Sin carpeta</strong>
            </article>
        @endif

        @forelse ($foldersToShow as $folder)
            <article wire:click="selectFolder({{ $folder->id }})"
                class="cursor-pointer group rounded-md border border-outline
                       bg-surface-alt p-3 hover:shadow-sm transition
                       flex flex-col gap-2">

                <div class="flex items-center gap-2">
                    <div class="flex items-center justify-center size-7 rounded-md bg-primary/10 text-primary">
                        <x-heroicon-o-folder class="w-3.5 h-3.5" />
                    </div>

                    <h3 class="text-xs font-semibold truncate text-on-surface-strong">
                        {{ $folder->name }}
                    </h3>

                    @if ($folder->tags->isNotEmpty())
                        <div class="flex flex-wrap gap-1 mt-1">
                            @foreach ($folder->tags as $tag)
                                <span
                                    class="px-2 py-0.5 text-[10px] rounded-full
                         bg-primary/10 text-primary">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div
                    class="mt-auto pt-2 border-t border-outline
                            flex justify-between text-[10px] text-on-surface">
                    <span class="flex items-center gap-1">
                        <x-heroicon-o-document-text class="w-3 h-3" />
                        {{ $folder->notes()->count() }} notas
                    </span>

                    <span>
                        {{ $folder->children->count() }} carpetas
                    </span>
                </div>
            </article>
        @empty
            <p class="text-sm text-on-surface col-span-full">
                No hay carpetas.
            </p>
        @endforelse
    </div>

</x-filament-panels::page>
