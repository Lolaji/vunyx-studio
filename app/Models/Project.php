<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded=[];

    public static function findBy($uuid, $field='uuid') 
    {
        return self::where($field, $uuid)->firstOrFail();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function video()
    {
        return $this->hasOne(Video::class);
    }

    public function elements()
    {
        return $this->hasMany(Element::class);
    }
    
    public function setting()
    {
        return $this->hasOne(ProjectSetting::class);
    }

    public function watch_users ()
    {
        return $this->hasMany(WatchUser::class);
    }

    public function embed_domains ()
    {
        return $this->hasMany(EmbedDomain::class);
    }

    public function canWatch ($username)
    {
        return $this->watch_users()->where('username', $username)->exists();
    }

    public function canEmbed ($domain)
    {
        return $this->embed_domains()->where('domain', $domain)->exists();
    }
}
