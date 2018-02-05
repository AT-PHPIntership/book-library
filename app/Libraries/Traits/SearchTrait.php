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
        $this->makeJoins($query);
    }

    /**
     * Get joins
     *
     * @return mixed
     */
    protected function getJoins()
    {
        return array_get($this->searchable, 'joins', []);
    }

    /**
     * Get joins
     *
     * @return mixed
     */
    protected function getLeftJoins()
    {
        return array_get($this->searchable, 'leftJoins', []);
    }

    /**
     * Make joins
     *
     * @param Builder $query query model
     *
     * @return void
     */
    protected function makeJoins($query)
    {
        foreach ($this->getJoins() as $table => $keys) {
            $query->join($table, function ($join) use ($keys) {
                $join->on($keys[0], '=', $keys[1]);
            });
        }
    }

    /**
     * Make joins
     *
     * @param Builder $query query model
     *
     * @return void
     */
    protected function makeLeftJoins($query)
    {
        foreach ($this->getLeftJoins() as $table => $keys) {
            $query->leftJoin($table, function ($join) use ($keys) {
                $join->on($keys[0], '=', $keys[1]);
            });
        }
    }
}
