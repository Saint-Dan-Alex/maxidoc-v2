<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivePermission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['agent_id', 'permissionable_id', 'permissionable_type', 'key'];

    public function permissionable()
    {
        return $this->morphTo();
    }
}
