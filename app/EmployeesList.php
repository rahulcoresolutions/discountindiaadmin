<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CoreSolutions\CoreAdmin\Observers\UserActionsObserver;


use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeesList extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table    = 'employeeslist';
    
    protected $fillable = [
          'name',
];
    

    public static function boot()
    {
        parent::boot();

        EmployeesList::observe(new UserActionsObserver);
    }
    
    
    
    
}