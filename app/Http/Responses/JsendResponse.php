<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 030 30 01 2015
 * Time: 17:33
 */

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class JsendResponse
{
    /**
     * Handle REST Success response
     *
     * @param $data
     * @return JsonResponse
     */
    public function success($data)
    {
        return new JsonResponse([
            'status'    => 'success',
            'data'      => $data
        ], 200);
    }

    /**
     * Handle REST Fail response
     *
     * @param $data
     * @param int $code
     * @return JsonResponse
     */
    public function fail($data, $code = 400)
    {
        if (null === $code) {
            $code = 400;
        }

        return new JsonResponse([
            'status'    => 'fail',
            'data'      => $data
        ], $code);
    }

    /**
     * Handle REST Error response
     *
     * @param $message
     * @param int $code
     * @return JsonResponse
     */
    public function error($message, $code = 500)
    {
        if (null === $code) {
            $code = 500;
        }

        return new JsonResponse([
            'status'    => $code,
            'message'   => $message
        ], $code);
    }
}
