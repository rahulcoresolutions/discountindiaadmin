<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CoreSolutions\CoreAdmin\Observers\UserActionsObserver;
use Illuminate\Database\Eloquent\SoftDeletes;

class RedeemPaidVouchers extends Model {


    protected $table    = 'redeemPaidVouchers';
    
    protected $fillable = [
        'voucherId',
		'userId',
        'voucherType',
		'paymentId',
		'status'
    ];

    public function voucher_details()
    {
    	return $this->belongsTo('App\PaidVouchers' , 'voucherId' , 'id' );
    }
    public function voucherPaidDetails()
    {
        return $this->belongsTo('App\PaidVouchers' , 'id' , 'voucherId' );
    }
    public function voucher()
    {
        return $this->belongsTo('App\Vouchers' , 'voucherId' , 'voucher_unique_id' );
    }
}