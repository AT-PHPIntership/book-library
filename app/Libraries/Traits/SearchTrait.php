<?php

namespace App\Libraries\Traits;

use Illuminate\Support\Facades\Schema;

trait SearchTrait
{
    /**
     * Search the result follow the search request and columns searchableFields.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query  Model
     * @param Request                               $search search
     * @param string                                $filter filter
     *
     * @return void.
     */
    public function scopeSearch($query, $search, $filter)
    {
        $columns = $this->searchable;
        foreach ($columns['input'] as $value) {
            if ($filter === $value[0]) {
                $query->where($value[0], $value[1], '%'.$search.'%');
            }
            if ($filter == config('define.all')) {
                $query->orWhere($value[0], $value[1], '%'.$search.'%');
            }
        }
    }

    /**
     * Search the result follow the search request
     *
     * @param \Illuminate\Database\Eloquent\Builder $query  Model
     * @param Request                               $search search
     *
     * @return void.
     */
    public function scopeSearchs($query, $search)
    {
        $columns = $this->searchable;
        foreach ($columns['input'] as $value) {
            $query->orWhere($value[0], $value[1], '%'.$search.'%');
        }
    }
}
