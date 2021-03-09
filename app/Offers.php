<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CoreSolutions\CoreAdmin\Observers\UserActionsObserver;
use App\Cities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Offers extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table    = 'offers';
    
    protected $fillable = [
        'title',
        'description',
        'attachment',
        'address',
        'mobile',
        'city',
        'email',
        'order',
        'category',
        'fax',
        'status'
    ];
    

    public static function boot()
    {
      parent::boot();

      Offers::observe(new UserActionsObserver);
    }
    
    public function title(){
        
    }
    public function vouchers()
    {
        return $this->hasMany('App\Vouchers' , 'voucher_of', 'id' );
    }
    
    public function category()
    {
        return $this->belongsTo('App\Categories', 'category' , 'id' );
    }
    public function categoryDetails()
    {
        return $this->belongsTo('App\Categories', 'category' , 'id' );
    }
}