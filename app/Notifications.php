<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CoreSolutions\CoreAdmin\Observers\UserActionsObserver;

class Notifications extends Model {
        
    protected $table    = 'notification';
    
    protected $fillable = [
        'message',
        'status'
    ];
    
}