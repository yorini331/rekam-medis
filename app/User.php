<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'name', 'email', 'password',
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
        return $this->belongsTo('App\Models\Role');
    }    
    public function isAdmin()
    {
        return $this->role->name === 'admin';
    }
 
    // public function hasRole($roles)
    // {
    //     $this->have_role = $this->getUserRole();
        
    //     if(is_array($roles)){
    //         foreach($roles as $need_role){
    //             if($this->cekUserRole($need_role)) {
    //                 return true;
    //             }
    //         }
    //     } else{
    //         return $this->cekUserRole($roles);
    //     }
    //     return false;
    // }
    // private function getUserRole()
    // {
    //    return $this->role()->getResults();
    // }
    
    // private function cekUserRole($role)
    // {
    //     return (strtolower($role)==strtolower($this->have_role->nama)) ? true : false;
    // }

}
