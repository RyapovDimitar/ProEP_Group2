<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Response;

class checkHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $value = $request->header('custom');
        if($value!=null){
            return $next($request);
        }
        else{
            return Response::json(array('error'=>'Authenticate Yourself!!!'));
        }
//        if(!isset($_SERVER['HTTP_X_HARDIK'])){
//            return Response::json(array('error'=>'Please set custom header'));
//        }
//
//        if($_SERVER['HTTP_X_HARDIK'] != '123456'){
//            return Response::json(array('error'=>'wrong custom header'));
//        }

    }
}
