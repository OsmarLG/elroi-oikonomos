<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class NoteUser extends Pivot
{
    protected $table = 'note_user';

    protected $fillable = [
        'note_id',
        'user_id',
        'role',
        'invited_at',
        'accepted_at',
    ];

    protected $casts = [
        'invited_at' => 'datetime',
        'accepted_at' => 'datetime',
    ];

    public $timestamps = false;
}
