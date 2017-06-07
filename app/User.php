<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @package App
 *
 * @SWG\Definition(
 *   definition="User",
 *   required={"email"}
 * )
 *
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The User email
     * @var string
     *
     * @SWG\Property(
     *   property="email",
     *   type="string",
     *   description="The user email"
     * )
     */

    /**
     * The user first name
     * @var string
     *
     * @SWG\Property(
     *   property="first_name",
     *   type="string",
     *   description="The user first name"
     * )
     */

    /**
     * The user last name
     * @var string
     *
     * @SWG\Property(
     *   property="last_name",
     *   type="string",
     *   description="The user last_name"
     * )
     */

    /**
     * The user birthday
     * @var string
     *
     * @SWG\Property(
     *   property="birtday",
     *   type="date",
     *   description="The user birthday"
     * )
     */

    /**
     * The product gender
     * @var string
     *
     * @SWG\Property(
     *   property="gender",
     *   type="string",
     *   description="The user gender"
     * )
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'first_name', 'last_name', 'birthday','gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    public function migrations()
    {
        return $this->hasMany('App\HumanMigration');
    }
}
