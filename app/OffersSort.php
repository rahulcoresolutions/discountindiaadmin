<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CoreSolutions\CoreAdmin\Observers\UserActionsObserver;

// use Illuminate\Database\Eloquent\SoftDeletes;

class OffersSort extends Model {

    // use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    // protected $dates = ['deleted_at'];

    protected $table    = 'offerslog';
    
    protected $fillable = [
        'orderId',
        'sortId',
        'date',
        'status'
    ];
    public function offers()
    {
        return $this->belongsTo('App\Offers' , 'orderId' , 'id');
    }
}