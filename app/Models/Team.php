<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'owner_id'];

    /* ======================
     |  OWNER
     |======================*/

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /* ======================
     |  MEMBERS
     |======================*/

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->using(TeamUser::class);
    }

    /* ======================
     |  NOTES
     |======================*/

    public function notes()
    {
        return $this->belongsToMany(Note::class)
            ->using(NoteTeam::class);
    }

    /* ======================
     |  FOLDERS
     |======================*/

    public function folders()
    {
        return $this->morphMany(Folder::class, 'folderable');
    }
}
