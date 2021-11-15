<?php

namespace App\Http\Response;

class JsonRpcResponse
{
    const JSON_RPC_VERSION = '2.0';

    public static function success($result)
    {
        return [
            'jsonrpc' => self::JSON_RPC_VERSION,
            'result'  => $result,
        ];
    }

    public static function error($error)
    {
        return [
            'jsonrpc' => self::JSON_RPC_VERSION,
            'error'   => $error,
        ];
    }
}
