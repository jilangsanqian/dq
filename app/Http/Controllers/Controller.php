<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function Response($params = [])
    {
        $code = 1;
        $data = [];
        $msg  = 'success';
        extract($params);
        $resutlData = [
            'code' => $code,
            'data' => $data,
            'msg' => $msg
        ];
        return (new Response($resutlData))
            ->setCharset('utf-8')
            ->send();
    }
}
