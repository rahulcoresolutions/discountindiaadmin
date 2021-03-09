<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CoreSolutions\CoreAdmin\Observers\UserActionsObserver;

class ShareVoucher extends Model {
        
    protected $table    = 'shareVoucher';
    
    protected $fillable = [
        'voucherId',
        'userId',
        'status',
        'amount',
        'expiredDate'
    ];
    public function user()
    {
        return $this->belongsTo('App\User' , 'userId','id');
    }
    public function voucher()
    {
        return $this->belongsTo('App\Vouchers' , 'voucherId' , 'voucher_unique_id');
    }
    public function voucherDetails()
    {
        return $this->belongsTo('App\Vouchers' , 'voucherId' , 'id');
    }
}