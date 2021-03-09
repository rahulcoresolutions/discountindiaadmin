<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use App\Role;
use CoreSolutions\CoreAdmin\Observers\UserActionsObserver;
use CoreSolutions\CoreAdmin\Traits\AdminPermissionsTrait;

class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, AdminPermissionsTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'mobile','role_id','plan_id','offerId' , 'customer_unique_id','expired_on','isFreePlan' , 'token'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public static function boot()
    {
        parent::boot();

        User::observe(new UserActionsObserver);
    }
    
    public function redeemedVoucherDetail(){
        return $this->HasMany('App\RedeemVoucher' , 'customer_unique_id', 'customer_unique_id');   
    }
    
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function plan(){
        return $this->belongsTo( 'App\Plans','plan_id','id' );
    }
    
    public function offers(){
        return $this->belongsTo( 'App\Offers','offerId','id' );
    }
}
