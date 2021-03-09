<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CoreSolutions\CoreAdmin\Observers\UserActionsObserver;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vouchers extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table  = 'vouchers';
    
    protected $fillable = [
            'title',
            'valid_date',
            'terms_condition',
            'barcode',
            'discount',
            'voucher_of',
            'voucher_template',
            'voucher_unique_id',
            'order'
    ];

   
    public function userVoucher()
    {
        return $this->belongsTo('App\RedeemVoucher' , 'voucher_unique_id' ,'voucher_unique_id');
    }
    public function vooucherDetails()
    {
        return $this->belongsTo('App\HotDeals' , 'voucher_unique_id' , 'voucher_id');    
    }  
    public static function boot()
    {
        parent::boot();

        Vouchers::observe(new UserActionsObserver);
    }
    public function Offer()
    {
        return $this->belongsTo('App\Offers' , 'voucher_of' ,'id');
    }

    public function vocuherDetails()
    {
        return $this->hasMany('App\RedeemVoucher' , 'voucher_unique_id' , 'voucher_unique_id');
    }
  
}