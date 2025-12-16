<?php

namespace App\Livewire;

use App\Models\Folder;
use App\Models\Note;
use App\Models\Tag;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class NoteEditor extends Component implements HasForms
{
    use InteractsWithForms;

    public Note $note;
    public array $tags = [];
    public string $newTag = '';

    public array $data = [];

    protected $rules = [
        'note.content' => 'nullable|string',
        'newTag'       => 'nullable|string|max:50',
    ];

    public function mount(int $noteId): void
    {
        $this->note = Note::findOrFail($noteId);
        $this->tags = $this->note->tags->pluck('name')->toArray();

        // IMPORTANTE: el schema solo maneja content
        $this->form->fill([
            'content' => $this->note->content,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema($this->getFormSchema());
    }

    protected function getFormSchema(): array
    {
        return [
            MarkdownEditor::make('content')
                ->label('Contenido de la nota')
                ->disableToolbarButtons(['attachFiles'])
                ->placeholder('Escribe tu nota aquí...')
                ->columnSpanFull(),
        ];
    }

    public function saveForm(): void
    {
        $data = $this->form->getState();

        $this->note->update([
            'content' => $data['content'] ?? '',
        ]);

        $this->dispatch('refreshFoldersAndNotes');
    }

    public function saveNoteTitleFromEditor(): void
    {
        $this->note->save();
        $this->dispatch('refreshFoldersAndNotes');
    }

    public function getAvailableFoldersProperty(): Collection
    {
        $ctx = [
            'type' => auth()->user()::class,
            'id'   => auth()->id(),
        ];

        $rootFolders = Folder::query()
            ->whereNull('parent_id')
            ->where('folderable_type', $ctx['type'])
            ->where('folderable_id', $ctx['id'])
            ->with('children')
            ->orderBy('name')
            ->get();

        $flattened = collect();
        foreach ($rootFolders as $folder) {
            $this->flattenFoldersRecursively($folder, $flattened);
        }

        return collect([(object)['id' => null, 'name' => 'Sin carpeta']])->merge($flattened);
    }

    private function flattenFoldersRecursively(Folder $folder, Collection &$collection, int $level = 0): void
    {
        $indent = str_repeat('-- ', $level);
        $collection->push((object)['id' => $folder->id, 'name' => $indent . $folder->name]);

        foreach ($folder->children as $child) {
            $this->flattenFoldersRecursively($child, $collection, $level + 1);
        }
    }

    public function saveNoteFolder(?int $folderId): void
    {
        $this->note->folder_id = $folderId;
        $this->note->save();

        $this->dispatch('refreshFoldersAndNotes');
    }

    public function addTag(): void
    {
        $this->validateOnly('newTag');

        if (empty($this->newTag)) return;

        $tag = Tag::firstOrCreate([
            'name' => $this->newTag,
            'slug' => Str::slug($this->newTag),
        ]);

        $this->note->tags()->syncWithoutDetaching([$tag->id]);

        $this->tags = $this->note->tags->pluck('name')->toArray();
        $this->newTag = '';

        $this->dispatch('refreshFoldersAndNotes');
    }

    public function removeTag(string $tagName): void
    {
        $tag = Tag::where('name', $tagName)->first();
        if (! $tag) return;

        $this->note->tags()->detach($tag->id);
        $this->tags = $this->note->tags->pluck('name')->toArray();

        $this->dispatch('refreshFoldersAndNotes');
    }

    public function getExistingTagsProperty(): Collection
    {
        return Tag::query()
            ->where('name', 'like', '%'.$this->newTag.'%')
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name']);
    }

    public function render()
    {
        return view('livewire.note-editor');
    }
}
