<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CoreSolutions\CoreAdmin\Observers\UserActionsObserver;


use Illuminate\Database\Eloquent\SoftDeletes;

class Topslider extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table    = 'topslider';
    
    protected $fillable = [
          'attachment',
          'active'
    ];
    

    public static function boot()
    {
        parent::boot();

        Topslider::observe(new UserActionsObserver);
    }
    
    
    
    
}