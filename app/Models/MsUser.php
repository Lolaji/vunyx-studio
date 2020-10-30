<?php

/**
 * Main site user model
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsUser extends Model
{
    use HasFactory;

    protected $connection='mysql2';
    protected $guarded=[];
    protected $table='register';

    public function vxUser()
    {
        return $this->hasOne(VxUser::class, 'vx_user_id', 'user_id');
    }
}
