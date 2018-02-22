<?php

namespace App\Libraries\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponse
{
    /**
     * Response list data
     *
     * @param Collection $collection collection
     * @param int        $code       response status
     *
     * @return \Illuminate\Http\Response
     */
    protected function showAll(Collection $collection, $code = 200)
    {
        $collection = $this->paginate($collection);
        return $this->structJson($collection, $code);
    }

    /**
     * Response data
     *
     * @param Model $instance instance of Model
     * @param int   $code     response status
     *
     * @return \Illuminate\Http\Response
     */
    protected function showOne(Model $instance, $code = 200)
    {
        return $this->successResponse($instance, $code);
    }

    /**
     * Pagination
     *
     * @param Collection $collection collection
     *
     * @return \Illuminate\Http\Response
     */
    protected function paginate(Collection $collection)
    {
        $rules = [
            'pre_page' => 'integer|min:2|max:50'
        ];
        Validator::validate(request()->all(), $rules);
        $page = LengthAwarePaginator::resolveCurrentPage();
        $prePage = 20;
        if (request()->has('pre_page')) {
            $prePage = request()->pre_page;
        }
        $result = $collection->slice(($page - 1) * $prePage, $prePage);
        $paginated = new LengthAwarePaginator($result, $collection->count(), $prePage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);
        $paginated->appends(request()->all());
        return $paginated;
    }

    /**
     * Structure of json
     *
     * @param LengthAwarePaginator $collection result response
     * @param int                  $code       response status
     *
     * @return Illuminate\Support\Collection
     */
    public function structJson($collection, $code)
    {
        $collectionStruct = collect([
            'meta' => [
                'status' => 'successfully',
                'code' => $code
            ],
            'data' => $collection->toArray()['data'],
            'total' =>  $collection->total(),
            'per_page' =>  $collection->perPage(),
            'current_page' =>  $collection->currentPage(),
            'total_pages' =>  $collection->lastPage(),
            'links' => [
                'prev' => $collection->previousPageUrl(),
                'next' =>$collection->nextPageUrl(),
            ]
        ]);
        return $collectionStruct;
    }
}
