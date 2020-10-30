<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VxUser extends Model
{
    use HasFactory;

    protected $guarded=[];

    public static function findBy($value, $field='id')
    {
        return self::where($field, $value)->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function msUser()
    {
        return $this->belongsTo(MsUser::class, 'vx_user_id', 'user_id');
    }

    public function videos()
    {
        return $this->hasMany(VxVideo::class, 'user_id', 'vx_user_id');
    }
}
