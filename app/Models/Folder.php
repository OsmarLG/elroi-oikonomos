<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasTags; // Import the trait

class Folder extends Model
{
    use SoftDeletes;
    use HasTags; // Use the HasTags trait
    
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

    /**
     * Scope to eager load children recursively and their notes count.
     */
    public function scopeWithRecursiveChildren(Builder $query): Builder
    {
        return $query->with(['children' => function ($query) {
            $query->withCount('notes')->withRecursiveChildren();
        }])->withCount('notes');
    }

    /* ======================
     |  NOTES
     |======================*/

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
