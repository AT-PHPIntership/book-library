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
        $search = '%' . $search . '%';

        if ($filter === config('define.all')) {
            $query->where(function ($where) use ($columns, $search, $filter) {
                foreach ($columns as $column) {
                    $where->orWhere($column, 'like', $search);
                }
            });
        } else if (in_array($filter, $columns)) {
            $query->where(function ($where) use ($columns, $search, $filter) {
                $where->orWhere($filter, 'like', $search);
            });
        }
    }
}
