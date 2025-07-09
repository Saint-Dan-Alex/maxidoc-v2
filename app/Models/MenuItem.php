<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;

class MenuItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Get all of the items for the MenuItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(MenuItem::class, 'parent_id', 'id')->orderBy('order');
    }

    public function hasChildren()
    {
        return $this->items->count() ? true : false;
    }

    public function link()
    {
        if (!empty($this->route) && $this->route != '' && $this->route != null) {
            return route($this->route);
        } elseif (!empty($this->url) && $this->url != '' && $this->url != null) {
            return url($this->url);
        } else {
            return 'javascript:void(0)';
        }
    }

    public function isActive()
    {
        if ($this->link() === url()->current()) {
            return true;
        }
        foreach ($this->items as $item) {
            if ($item->link() === url()->current()) {
                return true;
            }
        }
        return false;
    }
}
