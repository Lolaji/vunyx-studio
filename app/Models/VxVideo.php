<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VxVideo extends Model
{
    use HasFactory;

    protected $connection='mysql2';
    protected $guarded=[];
    protected $table='submit_video';

    public static function find($id)
    {
        return self::where('video_id', $id)->first();
    }

    public function user()
    {
        return  $this->belongsTo(VxUser::class, 'user_id', 'vx_user_id');
    }
}
