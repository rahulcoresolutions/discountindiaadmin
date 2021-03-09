<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CoreSolutions\CoreAdmin\Observers\UserActionsObserver;

use Carbon\Carbon; 

use Illuminate\Database\Eloquent\SoftDeletes;

class SubscribePlan extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table    = 'subscribeplan';
    
    protected $fillable = [
          'from',
          'to',
          'plan_id'
    ];
    

    public static function boot()
    {
        parent::boot();

        SubscribePlan::observe(new UserActionsObserver);
    }
    
    public function plan(){
        return $this->belongsTo('App\Plans' , 'plan_id' , 'id');
    }
    /**
     * Set attribute to date format
     * @param $input
     */
    // public function setFromAttribute($input)
    // {
    //     if($input != '') {
    //         $this->attributes['from'] = Carbon::createFromFormat(config('quickadmin.date_format'), Carbon::parse($input))->format('Y-m-d');
    //     }else{
    //         $this->attributes['from'] = '';
    //     }
    // }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    // public function getFromAttribute($input)
    // {
    //     if($input != '0000-00-00') {
    //         return Carbon::createFromFormat('Y-m-d', $input)->format(config('quickadmin.date_format'));
    //     }else{
    //         return '';
    //     }
    // }

/**
     * Set attribute to date format
     * @param $input
     */
    // public function setToAttribute($input)
    // {
    //     if($input != '') {
    //         $this->attributes['to'] = Carbon::createFromFormat(config('quickadmin.date_format'), $input)->format('Y-m-d');
    //     }else{
    //         $this->attributes['to'] = '';
    //     }
    // }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    // public function getToAttribute($input)
    // {
    //     if($input != '0000-00-00') {
    //         return Carbon::createFromFormat('Y-m-d', $input)->format(config('quickadmin.date_format'));
    //     }else{
    //         return '';
    //     }
    // }


    
}