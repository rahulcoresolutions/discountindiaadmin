<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CoreSolutions\CoreAdmin\Observers\UserActionsObserver;


use Illuminate\Database\Eloquent\SoftDeletes;

class HotDeals extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table    = 'hotdeals';
    
    protected $fillable = [
          'voucher_id',
          'banner'
    ];
    

    public static function boot()
    {
        parent::boot();

        HotDeals::observe(new UserActionsObserver);
    }
    
    
    public function vooucher()
    {
        return $this->belongsTo('App\Vouchers' , 'voucher_id' , 'id');    
    }    
    public function vooucherDetails()
    {
        return $this->belongsTo('App\Vouchers' , 'voucher_id' , 'voucher_unique_id');    
    }    
    
}