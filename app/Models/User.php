<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;
use App\Models\Badge;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The allowed values for the type_regime field.
     *
     * @var array
     */
    const TYPE_REGIME_ENUM = ['Fitnesse', 'musculation', 'prise_de_poids'];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'location',
        'phone',
        'about',
        'password_confirmation',
        'role',
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

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function isAdmin(): bool
    {

        return $this->role === 'admin';
    }

    public function santeMesures()
{
    return $this->hasMany(SanteMesure::class);
}
    public function habitudes()
{
    return $this->hasMany(Habitude::class);

}
public function badges()
{
     return $this->belongsToMany(Badge::class, 'badge_user')
                ->withPivot('total_points', 'acquired')
                ->withTimestamps();
}
        protected static function booted()
    {
        static::created(function ($user) {
            $allBadges = \App\Models\Badge::all();

            foreach ($allBadges as $badge) {
                $user->badges()->syncWithoutDetaching([
                    $badge->id => [
                        'total_points' => 0,
                        'acquired' => false,
                    ]
                ]);
            }
        });
    }
}
