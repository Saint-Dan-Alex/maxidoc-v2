<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the user that owns the Notification
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(Type_notification::class, 'type_id');
    }
    /**
     * Get the user that owns the Notification
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userSend()
    {
        return $this->belongsTo(User::class, 'user_send');
    }
    public function userReceve()
    {
        return $this->belongsTo(User::class, 'user_receve');
    }
 
    public function message()
    {
        return $this->belongsTo(Chat::class, 'content_id');
    }

    public function Countmessage()
    {
        return $this->hasMany(Chat::class);
    }

    public function Counttache()
    {
        return $this->hasMany(Tache::class);
    }
    public function tache()
    {
        return $this->belongsTo(Tache::class, 'content_id');
    }
    public function tach()
    {
        return $this->belongsTo(Tache::class, 'tache_id');
    }

    public function courrier()
    {
        return $this->belongsTo(Courrier::class, 'courrier_id');
    }

    public function Countcourrier()
    {
        return $this->hasMany(Courrier::class);
    }

}
