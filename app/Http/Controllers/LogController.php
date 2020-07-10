<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Services\Logs\LogService;
use App\Http\Services\Logs\GetLogService;


class LogController extends Controller
{
    /**
     * Add Package
     */
    public function insert(
        Request $request,
        LogService $logs
    )
    {
        $data = $request->all();
        return $logs->handle($data);
    }


    public function get(
        Request $request,
        GetLogService $logs
    )
    {
        $data = $request->all();
        return $logs->handle($data);
    }


}
