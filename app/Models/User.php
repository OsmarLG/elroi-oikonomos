<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Cashier\Billable;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    use HasPanelShield;
    use HasRoles;
    use Notifiable;
    use Billable;

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /* ======================
     |  TEAMS
     |======================*/

    // Teams que creó
    public function ownedTeams()
    {
        return $this->hasMany(Team::class, 'owner_id');
    }

    // Teams donde es miembro
    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    /* ======================
     |  NOTES
     |======================*/

    // Notas creadas por el usuario
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    // Notas donde colabora explícitamente
    public function sharedNotes()
    {
        return $this->belongsToMany(Note::class)
            ->using(NoteUser::class)
            ->withPivot(['role', 'invited_at', 'accepted_at']);
    }

    /* ======================
     |  FOLDERS
     |======================*/

    // Folders personales (contexto User)
    public function folders()
    {
        return $this->morphMany(Folder::class, 'folderable');
    }
}
