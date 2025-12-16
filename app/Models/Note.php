<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasTags; // Import the trait

class Note extends Model
{
    use SoftDeletes;
    use HasTags; // Use the HasTags trait

    protected $fillable = [
        'title',
        'content',
        'visibility',
        'folder_id',
        'user_id',
    ];

    /* ======================
     |  CONTEXTO
     |======================*/

    // User, Project, Task, Team, etc.
    public function noteable()
    {
        return $this->morphTo();
    }

    /* ======================
     |  AUTHOR
     |======================*/

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /* ======================
     |  FOLDER
     |======================*/

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    /* ======================
     |  COLLABORATION
     |======================*/

    // Usuarios colaboradores
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->using(NoteUser::class)
            ->withPivot(['role', 'invited_at', 'accepted_at']);
    }

    // Equipos colaboradores
    public function teams()
    {
        return $this->belongsToMany(Team::class)
            ->using(NoteTeam::class);
    }

    public function scopeVisibleTo($query, User $user)
    {
        return $query->where(function ($q) use ($user) {
            $q->where('visibility', 'public')

                // Autor
                ->orWhere('user_id', $user->id)

                // Usuario colaborador
                ->orWhereHas(
                    'users',
                    fn($uq) =>
                    $uq->where('users.id', $user->id)
                )

                // Equipo colaborador
                ->orWhereHas(
                    'teams.users',
                    fn($tq) =>
                    $tq->where('users.id', $user->id)
                );
        });
    }

    public function scopeEditableBy($query, User $user)
    {
        return $query->where(function ($q) use ($user) {

            // Autor siempre puede editar
            $q->where('user_id', $user->id)

                // Usuario colaborador con rol editor
                ->orWhereHas('users', function ($uq) use ($user) {
                    $uq->where('users.id', $user->id)
                        ->where('note_user.role', 'editor');
                })

                // Miembro de un team colaborador
                ->orWhereHas('teams.users', function ($tq) use ($user) {
                    $tq->where('users.id', $user->id);
                });
        });
    }

    public function attachments()
    {
        return $this->hasMany(NoteAttachment::class);
    }
}
