<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;
    public $remember_token = false;

    protected $fillable = ['name', 'username', 'password', 'email', 'phone_number', 'status', 'super_admin'];

    protected $casts = [
        'roles' => 'array',
    ];

    // protected function getDefaultGuardName(): string { return 'web'; }
}
