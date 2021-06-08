<?php
/**
 * Created by PhpStorm.
 * User: nael
 * Date: 9/7/17
 * Time: 10:06
 */

namespace App\Traits;
use stdClass;

trait ResponseTrait
{
    // This response for dashboard
    function generalResponse($status, $code, $title, $message, $data = null , $redirect = null)
    {
        $data = is_null($data) ? new stdClass() : $data;
        return response()->json(['status' => $status, 'code' => $code, 'title' => $title, 'message' => $message, 'data' => $data , 'redirect'=>$redirect]);
    }

    // This response for api
    function respondGeneral($status, $code, $message, $errors = null, $data = null)
    {
        $data = is_null($data) ? new stdClass() : $data;
        return response()->json(['status' => $status, 'code' => $code, 'message' => $message, 'errors' => $errors, 'data' => $data], $code);
    }
}
