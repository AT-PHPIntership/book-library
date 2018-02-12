<?php

namespace App\Libraries\Traits;

use Illuminate\Support\Facades\Schema;
use App\Model\Category;
use Illuminate\Http\Response;

trait ApiTrait
{
    /**
     * Convert paginate of $data
     *
     * @param array $data array
     *
     * @return Array
     */
    public function convertPaginateApi($data)
    {
        return [
        'data' => $data['data'],
        'paginate' => [
            'current_page' => $data['current_page'],
            'first_page_url' => $data['first_page_url'],
            'from' => $data['from'],
            'last_page' => $data['last_page'],
            'last_page_url' => $data['last_page_url'],
            'next_page_url' => $data['next_page_url'],
            'path' => $data['path'],
            'per_page' => $data['per_page'],
            'prev_page_url' => $data['prev_page_url'],
            'to' => $data['to'],
            'total' => $data['total'],
            ],
        ];
    }
    
    /**
     * Add meta success for $data.
     *
     * @param array $data array
     *
     * @return Array
     */
    public function success($data)
    {
        $data['meta'] = [
        'status' => "Successfully",
        'code'=> Response::HTTP_OK,

        ];
        return $data;
    }

    /**
     * Return error.
     *
     * @param int $code Code of error
     *
     * @return Array
     */
    public function fail($code)
    {
        return [
            'meta' => [
                'status' => "Fail",
                'code'=> $code,
            ],
        ];
    }
}
