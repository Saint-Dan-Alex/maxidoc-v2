<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccuseReception extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'courrier_id'];

    /**
     * Get the user that owns the AccuseReception
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the courrier that owns the AccuseReception
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function courrier()
    {
        return $this->belongsTo(Courrier::class, 'courrier_id');
    }
}
