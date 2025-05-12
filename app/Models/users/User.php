<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // Using Eloquent traits for factory generation and notification handling
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * This array defines which attributes can be filled with values 
     * when using mass assignment. These are typically user-provided 
     * inputs like their name, email, and password.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * This array contains attributes that should not be visible 
     * when the model is converted to an array or JSON. In this case,
     * the password and remember_token fields are excluded from
     * serialization for security reasons.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * This method defines how attributes should be cast to specific types
     * when retrieved from the database. For example, the `email_verified_at`
     * is cast to a `datetime` object, and the password is cast to a `hashed` 
     * attribute for security reasons.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',  // Casting to datetime type
            'password' => 'hashed',             // Ensure password is always stored as hashed
        ];
    }
}