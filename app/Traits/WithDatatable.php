<?php

namespace App\Traits;

trait WithDatatable
{
    /**
     * Scope a query to only include search
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $term, $columns)
    {
        if ((is_array($columns) || is_countable($columns)) && count($columns)) {
            $result = null;
            foreach ($columns as $key => $column) {
                if ($key == 0) {
                    $result = $query->where($column, "LIKE", "%{$term}%");
                }else{
                    $result = $query->orWhere($column, "LIKE", "%{$term}%");
                }
            }
            return $result;
        }

        return $this;
    }
}
