<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourrierNature extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['titre', 'category_id', 'modele'];

    public function category()
    {
        return $this->belongsTo(CourrierCategory::class, 'category_id');
    }
}
