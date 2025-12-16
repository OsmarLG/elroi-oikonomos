<?php

namespace App\Livewire;

use App\Models\Note;
use Livewire\Component;

class NoteEditor extends Component
{
    public Note $note;

    protected $rules = [
        'note.title'   => 'nullable|string|max:255',
        'note.content' => 'nullable|string',
    ];

    public function mount(int $noteId): void
    {
        $this->note = Note::findOrFail($noteId);
    }

    public function save(): void
    {
        $this->validate();
        $this->note->save();
    }

    public function render()
    {
        return view('livewire.note-editor');
    }
}
