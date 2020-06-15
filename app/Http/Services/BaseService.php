<?php

namespace App\Http\Services;

/**
 * Class BaseService
 *
 * @package App\Services
 */
abstract class BaseService
{
    /**
     * Absorb
     *
     * @param   array  $information  api response
     *
     * @return  json API response
     */
    public function absorb(array $information)
    {
        $data = (isset($information['data']) ? $information['data'] : []);
        $status = (isset($information['status']) ? $information['status'] : 200);
        $message = (isset($information['message']) ? $information['message'] : 'Ibial API Return');

        $return = [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];
        return json_encode($return);
    }
}
