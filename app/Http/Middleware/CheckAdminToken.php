<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
class CheckAdminToken
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
        $user = null;
        try{
            $user = JWTAuth::parseToken()->authenticate();
        }catch(\Exception $e){
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return $this->returnError('3001', 'INVALID_TOKEN');
            }else if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return $this->returnError('3001', 'EXPIRED_TOKEN');
            }else{
                return $this->returnError('3001', 'TOKEN_NOTFOUND');
            }
        }catch(\Throwable $e){
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this->returnError('3001', 'INVALID_TOKEN');
            }else if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return $this->returnError('3001', 'EXPIRED_TOKEN');
            }else{
                return $this->returnError('3001', 'TOKEN_NOTFOUND');
            }
        }
        if(!$user)
            return $this->returnError('3001', 'Unauthenticated');

        return $next($request);
    }
}
