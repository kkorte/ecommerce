<?php 

namespace Hideyo\Shop\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    /**
     * Detach multiple roles from a user
     *
     * @param mixed $roles
     *
     * @return void
     */
    public function detachAllRoles($roles)
    {

        foreach ($roles as $role) {
            $this->detachRole($role);
        }
    }


    public function getUserProfileData()
    {
        return $this->hasMany('UserProfileData');
    }

    public function shop()
    {
        return $this->belongsTo('App\Shop', 'selected_shop_id', 'id');
    }


    public function roles()
    {
        return $this->belongsToMany('App\Role', 'assigned_roles');
    }
}
