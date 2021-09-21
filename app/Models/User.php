<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_ADMIN = 'Admin';
    const ROLE_CLIENT = 'Client';

    const ROLES = [
        SELF::ROLE_ADMIN,
        SELF::ROLE_CLIENT
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'client_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the client assigned to user.
     */
    public function client()
    {
        return $this->belongsTo(
            Client::class,
            'client_id',
            'id'
        );
    }

    /**
     * Check the given id is not the current logged in user's id
     *
     * @param string $id
     *
     * @return bool
     */
    public function isLoggedInUserId(string $id)
    {
        return Auth::user()->id === $id;
    }

    /**
     * @return bool
     */
    public function isAdmin() : bool
    {
        return $this->role === SELF::ROLE_ADMIN;
    }

    /**
     * @return bool
     */
    public function isClient() : bool
    {
        return $this->role === SELF::ROLE_CLIENT;
    }

}
