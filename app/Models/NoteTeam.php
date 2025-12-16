<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class NoteTeam extends Pivot
{
    protected $table = 'note_team';

    protected $fillable = [
        'note_id',
        'team_id',
    ];

    public $timestamps = false;
}
