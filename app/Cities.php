<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CoreSolutions\CoreAdmin\Observers\UserActionsObserver;


use Illuminate\Database\Eloquent\SoftDeletes;

class Cities extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table    = 'cities';
    
    protected $fillable = [
          'city',
          'country'
    ];
    

    public static function boot()
    {
        parent::boot();

        Cities::observe(new UserActionsObserver);
    }
    
    
    
    
}