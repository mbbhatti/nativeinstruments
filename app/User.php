<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * Has many relation for user and products.
     */
    public function products()
    {        
        return $this->belongsToMany('App\Product', 'purchaseds');
    }

    /**
     * Check auth user.
     *
     * @param  string   $email
     * @return object|boolean    
     */
    public function checkAuth(string $email)
    {
        $data =  User::where('email', $email)
                    ->first(['id', 'name']);
        
        return !empty($data) ? $data : false;
    }
}
