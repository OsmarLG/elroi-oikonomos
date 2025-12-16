<?php

namespace App\Filament\Pages;

use App\Models\Folder;
use App\Models\Note;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;
use BackedEnum;
use UnitEnum;
use Illuminate\Support\Collection;

class NotesWorkspace extends Page
{
    use WithPagination;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentText;
    protected static string|UnitEnum|null $navigationGroup = 'Workspace';
    protected static ?string $slug = 'workspace/notes';
    protected static ?string $navigationLabel = 'Notas';
    protected static ?string $title = 'Notas';

    protected string $paginationTheme = 'tailwind';

    /** Estado simple (permitido) */
    public ?int $selectedFolderId = null;

    public const ALL_NOTES = null;
    public const NO_FOLDER = -1;

    public function getView(): string
    {
        return 'filament.pages.notes-workspace';
    }

    /* =========================
     | FOLDERS (NO PAGINADOS)
     ========================= */
    public function getFoldersProperty(): Collection
    {
        if ($this->selectedFolderId > 0) {
            return $this->selectedFolder?->children ?? collect();
        }

        return Folder::whereNull('parent_id')->get();
    }

    public function getSelectedFolderProperty(): ?Folder
    {
        if (!$this->selectedFolderId) {
            return null;
        }

        return Folder::with('children')
            ->find($this->selectedFolderId);
    }

    /* =========================
     | RECENT NOTES (SIN PAGINAR)
     ========================= */
    public function getLastNotesProperty(): Collection
    {
        return Note::query()
            ->latest('updated_at')
            ->limit(3)
            ->get();
    }

    /* =========================
     | NOTES (PAGINADAS)
     ========================= */
    public function getNotesProperty()
    {
        return Note::query()
            ->when(
                $this->selectedFolderId === self::NO_FOLDER,
                fn($q) =>
                $q->whereNull('folder_id')
            )
            ->when(
                is_int($this->selectedFolderId) && $this->selectedFolderId > 0,
                fn($q) => $q->where('folder_id', $this->selectedFolderId)
            )
            ->latest('updated_at')
            ->paginate(9);
    }

    /* =========================
     | ACTIONS
     ========================= */
    public function selectFolder(?int $folderId = null): void
    {
        $this->selectedFolderId = $folderId;
        $this->resetPage();
    }

    public function selectNote(int $noteId): void
    {
        // luego abrir editor
    }

    public function getBreadcrumbsProperty(): Collection
    {
        $crumbs = collect();

        // Siempre inicio
        $crumbs->push([
            'id' => self::ALL_NOTES,
            'label' => 'Todas las notas',
        ]);

        // CASO: Sin carpeta
        if ($this->selectedFolderId === self::NO_FOLDER) {
            $crumbs->push([
                'id' => self::NO_FOLDER,
                'label' => 'Sin carpeta',
            ]);

            return $crumbs;
        }

        // CASO: Carpeta real
        $folder = $this->selectedFolder;

        if (! $folder) {
            return $crumbs;
        }

        $stack = collect();

        while ($folder) {
            $stack->push([
                'id' => $folder->id,
                'label' => $folder->name,
            ]);

            $folder = $folder->parent;
        }

        return $crumbs->merge($stack->reverse());
    }

    public function goToFolder(?int $folderId = null): void
    {
        $this->selectedFolderId = $folderId;
        $this->resetPage();
    }
}
