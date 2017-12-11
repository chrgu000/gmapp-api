<?php
namespace app\common\exception;

use think\exception\Handle;
use think\exception\HttpException;

class Http extends Handle
{

    public function render(\Exception $e)
    {
        if ($e instanceof HttpException) {
            $statusCode = $e->getStatusCode();
        }

        if (!isset($statusCode)) {
            $statusCode = 500;
        }

        $msg  = $e->getMessage();

        $result = [
            'code'   => $statusCode,
            'msg'    => $msg,
        ];
        return json($result, $statusCode);
    }

}