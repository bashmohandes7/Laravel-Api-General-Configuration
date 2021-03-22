<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{
    use GeneralTrait;
    public function login(Request $request){
        // Validation

        try {


            $rules = [
                'email' => 'required',
                'password' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            // Login
            $credentials = $request->only(['email', 'password']);
            $token = Auth::guard('user-api')->attempt($credentials);
            if (!$token)
                return $this->returnError('E001', 'بيانات المستخدم غير صحيحة');
            $user = Auth::guard('user-api')->user();
            $user->user_token = $token;
            return $this->returnData('user', $user, 'تم جلب بيانات المستخدم بنجاح');
        }catch (\Exception $e){
            return  $this->returnError($e->getCode(), $e->getMessage());
        }
    }
}
