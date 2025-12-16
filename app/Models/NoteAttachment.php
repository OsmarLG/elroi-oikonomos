<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class NoteAttachment extends Model
{
    protected $fillable = [
        'note_id',
        'path',
        'disk',
        'mime',
        'size',
        'original_name',
        'created_by',
    ];

    protected $appends = ['url'];

    public function note()
    {
        return $this->belongsTo(Note::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getUrlAttribute()
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    public function isImage(): bool
    {
        return str_starts_with($this->mime, 'image/');
    }
}