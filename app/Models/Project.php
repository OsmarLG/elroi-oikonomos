<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'customer_id', 'visibility'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'noteable');
    }

    public function folders()
    {
        return $this->morphMany(Folder::class, 'folderable');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->using(ProjectUser::class)
            ->withPivot(['role', 'invited_at', 'accepted_at']);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class)
            ->using(ProjectTeam::class);
    }
}
