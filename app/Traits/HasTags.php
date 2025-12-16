<?php

namespace App\Traits;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;

trait HasTags
{
    /**
     * Get all of the tags for the model.
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Attach a tag to the model.
     */
    public function attachTag(string|Tag $tag): void
    {
        if (is_string($tag)) {
            $tag = Tag::firstOrCreate(['name' => $tag]);
        }

        $this->tags()->syncWithoutDetaching([$tag->id]);
    }

    /**
     * Detach a tag from the model.
     */
    public function detachTag(string|Tag $tag): void
    {
        if (is_string($tag)) {
            $tag = Tag::where('name', $tag)->first();
        }

        if ($tag) {
            $this->tags()->detach($tag->id);
        }
    }

    /**
     * Sync tags for the model.
     */
    public function syncTags(array|Collection $tags): void
    {
        $tagIds = collect($tags)->map(function ($tag) {
            if (is_string($tag)) {
                return Tag::firstOrCreate(['name' => $tag])->id;
            }
            return $tag instanceof Tag ? $tag->id : $tag;
        })->toArray();

        $this->tags()->sync($tagIds);
    }

    /**
     * Get tags as a comma-separated string.
     */
    public function getTagsStringAttribute(): string
    {
        return $this->tags->pluck('name')->implode(', ');
    }
}
