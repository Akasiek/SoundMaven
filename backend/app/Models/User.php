<?php

namespace App\Models;

use App\Enums\UserRoles;
use Cocur\Slugify\Slugify;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use SoftDeletes, HasFactory, Notifiable, Sluggable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => UserRoles::class,
    ];

    protected $attributes = [
        'role' => UserRoles::USER,
    ];

    public function sluggable(): array
    {
        return ['slug' => [
            'source' => 'name',
            'method' => static function (string $string, string $separator): string {
                return new Slugify(['separator' => $separator])->slugify($string) ?: 'unnamed';
            }
        ]];
    }
}
