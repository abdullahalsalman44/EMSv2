<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService) {
        $this->userService=$userService;
    }

    public function register(UserRegisterRequest $request){
           return $this->userService->register($request->validated());
    }

    public function login(UserLoginRequest $request){
        return $this->userService->login($request->validated());
    }

    public function logout(){
        return $this->userService->logout();
    }

    public function checkVerifyCode(Request $request){
        return $this->userService->checkCode($request->code);
    }

    public function forgetPassword(Request $request){
        return $this->userService->sendEmailVerifyToResetPassword($request->userEmail);
    }

    public function reSetPassword(Request $request){
        return $this->userService->reSetPassword($request->code,$request->newpassword);
    }

    public function getUserInformations(){
        return $this->userService->getUserInformations();
    }

    public function deleteUserAccount(){
        return $this->userService->deleteMyAccount();
    }

    public function checkDeleteCode(Request $request){
        return $this->userService->checkDeleteAccountCode($request->code);
    }
}

