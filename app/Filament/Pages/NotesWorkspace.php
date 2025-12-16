<?php

namespace App\Filament\Pages;

use App\Models\Folder;
use App\Models\Note;
use Filament\Pages\Page;
use Illuminate\Support\Collection;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use UnitEnum;

class NotesWorkspace extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentText;
    protected static ?string $navigationLabel = 'Notas';
    protected static ?string $title = 'Notas';
    protected static string|UnitEnum|null $navigationGroup = 'Workspace';

    /* =========================
     | STATE
     ========================= */
    public ?int $selectedFolder = null;
    public ?int $selectedNote = null;

    /* =========================
     | VIEW
     ========================= */
    public function getView(): string
    {
        return 'filament.pages.notes-workspace';
    }

    /* =========================
     | CONTEXT
     ========================= */
    protected function folderContext(): array
    {
        return [
            'type' => auth()->user()::class,
            'id'   => auth()->id(),
        ];
    }

    /* =========================
     | DATA
     ========================= */
    public function getFoldersProperty(): Collection
    {
        $ctx = $this->folderContext();

        return Folder::query()
            ->whereNull('parent_id')
            ->where('folderable_type', $ctx['type'])
            ->where('folderable_id', $ctx['id'])
            ->with('children')
            ->orderBy('name')
            ->get();
    }

    public function getNotesProperty(): Collection
    {
        return Note::query()
            ->visibleTo(auth()->user())
            ->when(
                $this->selectedFolder,
                fn ($q) => $q->where('folder_id', $this->selectedFolder)
            )
            ->latest()
            ->get();
    }

    /* =========================
     | ACTIONS
     ========================= */
    public function selectFolder(int $id): void
    {
        $this->selectedFolder = $id;
        $this->selectedNote = null;
    }

    public function selectNote(int $id): void
    {
        $this->selectedNote = $id;
    }

    public function createFolder(): void
    {
        $ctx = $this->folderContext();

        Folder::create([
            'name'            => 'Nueva carpeta',
            'parent_id'       => null,
            'visibility'      => 'private',
            'folderable_type' => $ctx['type'],
            'folderable_id'   => $ctx['id'],
        ]);
    }

    public function createNote(): void
    {
        $note = Note::create([
            'title'         => 'Nueva nota',
            'content'       => '',
            'visibility'    => 'private',
            'folder_id'     => $this->selectedFolder,
            'user_id'       => auth()->id(),
            'noteable_type' => auth()->user()::class,
            'noteable_id'   => auth()->id(),
        ]);

        $this->selectedNote = $note->id;
    }
}
