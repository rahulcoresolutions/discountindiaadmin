<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CoreSolutions\CoreAdmin\Observers\UserActionsObserver;


use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table    = 'subcategory';
    
    protected $fillable = [
          'title',
          'attachment','offers'
    ];
    

    public static function boot()
    {
        parent::boot();

        Subcategory::observe(new UserActionsObserver);
    }
    
    
    
    
}