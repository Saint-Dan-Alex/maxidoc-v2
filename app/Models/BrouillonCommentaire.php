<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrouillonCommentaire extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function brouillon()
    {
        return $this->belongsTo(Brouillon::class, 'brouillon_id');
    }
}