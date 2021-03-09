<?php
namespace CoreSolutions\CoreAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class UsersLogs extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'action_model',
        'action_id',
    ];

    public function users()
    {
        return $this->hasOne(config('coreadmin.userModel'), 'id', 'user_id');
    }
}
