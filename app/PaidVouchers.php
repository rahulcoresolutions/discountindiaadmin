<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CoreSolutions\CoreAdmin\Observers\UserActionsObserver;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaidVouchers extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table  = 'paidvouchers';
    
    protected $fillable = [
            'title',
            'valid_date',
            'terms_condition',
            'barcode',
            'discount',
            'voucher_of',
            'voucher_template',
            'custom_template',
            'voucher_unique_id',
            'fileName',
            'customer_price',
            'hotel_price',
            'discount_india_price',
    ];

    public static function boot()
    {
        parent::boot();

        Vouchers::observe(new UserActionsObserver);
    }
    
    public function voucher()
    {
        return $this->belongsTo('App\Vouchers' , 'voucher_unique_id' , 'voucher_unique_id');
    }
    public function Offer()
    {
        return $this->belongsTo('App\Offers' , 'voucher_of' ,'id');
    }
    public function voucherDetails()
    {
        return $this->belongsTo('App\Vouchers' , 'voucher_of' ,'voucher_unique_id');
    }

}