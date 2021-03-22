<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

class AuthController extends Controller
{
    use GeneralTrait;

    public function login(Request $request){
        //Validate All Requests
        try {

            $rules = [
                "email" => "required",
                "password" => "required"
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            // Login
            $credentials = $request->only(['email', 'password']);
            $token = Auth::guard('admin-api')->attempt($credentials);
            if (!$token)
                return $this->returnError('E001', 'بيانات الدخول غير صحيحة');

                // return token
            $admin = Auth::guard('admin-api')->user();
            $admin->api_token = $token;
                return $this->returnData('admin', $admin, 'تم جلب التوكين بنجاح');

        }catch (\Exception $e){
            return  $this->returnError($e->getCode(), $e->getMessage());
        }
    }
    public function logout(Request $request)
    {

        $token = $request->header('auth-token');
        if ($token) {
            try {
                JWTAuth::setToken($token)->invalidate(); // logout
                return $this->returnSuccessMessage('', 'Logged out Successfully');
            } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                return $this->returnError('', 'Some Thing Went Wrong');
            }
        } else{
                return $this->returnError('', 'Some Thing Went Wrong!');
            }

    }

}
