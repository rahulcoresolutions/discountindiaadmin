<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CoreSolutions\CoreAdmin\Observers\UserActionsObserver;

use Carbon\Carbon; 

use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table    = 'delivery';
    
    protected $fillable = [
          'attachment',
          'mobile',
          'valid',
          'city'
    ];
    

    public static function boot()
    {
        parent::boot();

        Delivery::observe(new UserActionsObserver);
    }
    
    
    // /**
    //  * Set attribute to date format
    //  * @param $input
    //  */
    // public function setValidAttribute($input)
    // {
    //     if($input != '') {
    //         $this->attributes['valid'] = Carbon::createFromFormat(config('quickadmin.date_format'), $input)->format('Y-m-d');
    //     }else{
    //         $this->attributes['valid'] = '';
    //     }
    // }

    // /**
    //  * Get attribute from date format
    //  * @param $input
    //  *
    //  * @return string
    //  */
    // public function getValidAttribute($input)
    // {
    //     if($input != '0000-00-00') {
    //         return Carbon::createFromFormat('Y-m-d', $input)->format(config('quickadmin.date_format'));
    //     }else{
    //         return '';
    //     }
    // }


    
}