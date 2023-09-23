<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'birth_day',
        'gender',
        'street_address',
        'city',
        'postal_code',
        'country',
        'state',
        'local',
    ];

    public function user () {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
