<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'project_id',
        'status_id',
        'order',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function status()
    {
        return $this->belongsTo(ProjectStatus::class);
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'noteable');
    }
}
