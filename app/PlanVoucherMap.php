<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CoreSolutions\CoreAdmin\Observers\UserActionsObserver;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanVoucherMap extends Model {


    protected $table    = 'plan_voucher_map';
    
    protected $fillable = [
        'id',
        'vooucher_id',
        'plan_id',
        'string'
    ];
    
    
    
    
    
}