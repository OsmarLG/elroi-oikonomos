<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Folder extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['name', 'parent_id', 'visibility', 'folderable_type', 'folderable_id'];

    /* ======================
     |  CONTEXTO
     |======================*/

    // User, Project, Task, Team, etc.
    public function folderable()
    {
        return $this->morphTo();
    }

    /* ======================
     |  JERARQUÍA
     |======================*/

    public function parent()
    {
        return $this->belongsTo(Folder::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }

    /* ======================
     |  NOTES
     |======================*/

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
