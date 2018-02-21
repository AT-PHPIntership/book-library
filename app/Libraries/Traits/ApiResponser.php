<?php

namespace App\Libraries\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponser
{
    private function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    protected function showAll(Collection $collection, $code = 200)
    {
        if ($collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $code);
        }
                
        $collection = $this->paginate($collection);
        $collection = $this->structJson($collection->toArray(), $code);
        return $this->successResponse($collection, $code);
    }

    protected function paginate(Collection $collection)
    {
        $rules = [
            'per_page' => 'integer|min:2|max:50'
        ];
        
        Validator::validate(request()->all(), $rules);
        
        $page = LengthAwarePaginator::resolveCurrentPage();
        
        $perPage = config('define.item_limit');
        if (request()->has('per_page')) {
            $perPage = request()->per_page;
        }
        
        $result = $collection->slice(($page - 1) * $perPage, $perPage);
        
        $paginated = new LengthAwarePaginator($result, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);
        
        $paginated->appends(request()->all());
        
        return $paginated;
    }

    /**
     * Structure of json
     *
     * @param array $resonseArray array response
     * @param int   $code         response status
     *
     * @return Illuminate\Support\Collection
     */
    public function structJson($resonseArray, $code = 200)
    {
        $count = count($resonseArray['data']) % $resonseArray['per_page'];
        $collection = collect([
            'meta' => [
                'status' => 'success',
                'code' => $code
            ],
            'data' => array_values($resonseArray['data']),
            'pagination' => [
                'total' =>  $resonseArray['total'],
                'count' =>  $count != 0 ? $count : $resonseArray['per_page'],
                'per_page' =>  $resonseArray['per_page'],
                'current_page' =>  $resonseArray['current_page'],
                'total_pages' =>  $resonseArray['last_page'],
                'links' => [
                   'prev' => $resonseArray['prev_page_url'],
                   'next' =>$resonseArray['next_page_url']
                ]
            ],
        ]);
        return $collection;
    }

}