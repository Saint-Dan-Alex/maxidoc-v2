<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourrierCategory extends Model
{
    use HasFactory;
    protected $fillable = ['title','type_id'];
    
    public function type()
    {
        return $this->belongsTo(CourrierType::class, 'type_id');
    }

}
