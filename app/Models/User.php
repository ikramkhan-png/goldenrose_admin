<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',        // admin / client / employee
        'client_type', // service / project
        'phone',
    ];

    protected $guard_name = 'web';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Client → Projects
   public function projects()
    {
        return $this->hasMany(\App\Models\Project::class, 'client_id', 'id');
    }

    public function services()
    {
        return $this->hasMany(\App\Models\ClientService::class, 'client_id', 'id');
    }

    
}