<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Str;

class Tag extends Model
{
    protected $fillable = ['name', 'slug'];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Tag $tag) {
            $tag->slug = Str::slug($tag->name);
        });

        static::updating(function (Tag $tag) {
            if ($tag->isDirty('name')) {
                $tag->slug = Str::slug($tag->name);
            }
        });
    }

    /**
     * Get all of the models that are assigned this tag.
     */
    public function notes(): MorphToMany
    {
        return $this->morphedByMany(Note::class, 'taggable');
    }

    public function folders(): MorphToMany
    {
        return $this->morphedByMany(Folder::class, 'taggable');
    }
}
