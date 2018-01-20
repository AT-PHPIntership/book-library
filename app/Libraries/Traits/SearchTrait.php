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
            foreach ($columns['type'] as $index) {
                if ($filter === $value) {
                    $query->Where($value, $index, '%'.$search.'%');
                }
                if ($filter == 'all') {
                    $query->orWhere($value, $index, '%'.$search.'%');
                }
            }
        }
    }
}
