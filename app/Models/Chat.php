<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $guarded = [''];

    public function user_receve(){
        return $this->belongsTo(User::class,'user_receve');
    }

    public function user_send(){
        return $this->belongsTo(User::class,'user_send');
    }
    public function Send(){
        return $this->belongsTo(User::class,'user_send');
    }

 


}
