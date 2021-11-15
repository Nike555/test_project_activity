<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Http\Response\JsonRpcResponse;
use Illuminate\Http\Request;

class JsonRpcServer
{
    public function handle(Request $request, Controller $controller)
    {
        try {
            $content = json_decode($request->getContent(), true);

            $result = $controller->{$content['method']}(...[$content['params']]);

            return JsonRpcResponse::success($result);
        } catch (\Exception $e) {
            return JsonRpcResponse::error($e->getMessage());
        }
    }
}
