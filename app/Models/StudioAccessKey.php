<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudioAccessKey extends Model
{
    use HasFactory;

    public static function authenticate($access_token=null)
    {
        if ($access_token) {
            return self::where('token', $access_token)
                            ->where('is_enabled', 1)->exists();
        }
        return false;
    }
}
