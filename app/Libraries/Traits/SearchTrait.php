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

        $query->where(function ($where) use ($columns, $search, $filter) {
            foreach ($columns['input'] as $value) {
                if ($filter === $value[0]) {
                    $where->orWhere($value[0], $value[1], '%'.$search.'%');
                }
                if ($filter == config('define.all')) {
                    $where->orWhere($value[0], $value[1], '%'.$search.'%');
                }
            }
        });
    }
}
