<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CoreSolutions\CoreAdmin\Observers\UserActionsObserver;


use Illuminate\Database\Eloquent\SoftDeletes;

class Plans extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table    = 'plans';
    
    protected $fillable = ['title','desc','price','valid','image','contactno'];
    

    public static function boot()
    {
        parent::boot();

        Plans::observe(new UserActionsObserver);
    }
    
    
    public function users(){
        return $this->hasMany('App\User' , 'plan_id', 'id' );
    }
    
}