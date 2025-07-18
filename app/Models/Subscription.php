<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Subscription extends Model
{
    use HasFactory;

    /**
     * Get the parent commentable model (post or video).
     */
    public function subscribable(): MorphTo
    {
        return $this->morphTo();
    }
}
