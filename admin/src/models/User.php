<?php

namespace Kaya\Admin\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles;

    /**
     * This is the guard name for the roles.
     * 
     * @var string
     */
    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Set attributes that are mass assignable.
     * @param array attributes
     */
    public function setFillable(array $attributes) {
        $this->fillable = $attributes;
    }

    /**
     * Create new instance of User from another model of users.
     * @param $user
     * @return User
     */
    static public function make ($user) {
        $instance = new User([]);
        $instance->setFillable(array_merge($instance->getFillable(), $user->getFillable()));
        return $instance->fill($user->toArray());
    }
}