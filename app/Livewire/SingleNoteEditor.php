<?php

namespace App\Livewire;

use App\Models\Note;
use Livewire\Component;

class SingleNoteEditor extends Component
{
    public Note $note;

    public function mount(Note $note): void
    {
        $this->note = $note;
    }

    public function render()
    {
        return view('livewire.single-note-editor')
            ->layout('components.layouts.app'); // Assuming you have a default app layout
    }
}
