<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const STATUS_ONLINE = 0;
    const STATUS_GET_AWAY = 1;
    const STATUS_NOT_DISTURB = 2;

    public static function getStatuses()
    {
        return [
            self::STATUS_ONLINE => 'Онлайн',
            self::STATUS_GET_AWAY => 'Отошел',
            self::STATUS_NOT_DISTURB => 'Не беспокоить',
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function register($data)
    {
        $user = new self;
        $user->fill($data);
        $user->password = bcrypt($data['password']);
        $user->save();
        return $user;
    }

}
