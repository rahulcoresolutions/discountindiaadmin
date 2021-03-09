<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CoreSolutions\CoreAdmin\Observers\UserActionsObserver;




class RedeemVoucher extends Model {

    

    

    protected $table    = 'redeemvoucher';
    
    protected $fillable = [
          'customer_unique_id',
          'voucher_unique_id',
          'voucher_title',
          'status',
          'redeem_by'
    ];
    

    public static function boot()
    {
        parent::boot();

        RedeemVoucher::observe(new UserActionsObserver);
    }
    
    public function listCustomerDetails(){
        return $this->HasMany('App\User' , 'customer_unique_id', 'customer_unique_id');   
    } 
    
    public function customerDetails(){
        return $this->belongsTo('App\User' , 'customer_unique_id' , 'customer_unique_id');   
    }
    public function voucherDetails(){
        return $this->belongsTo('App\Vouchers' , 'voucher_unique_id' , 'voucher_unique_id');   
    }
    
}