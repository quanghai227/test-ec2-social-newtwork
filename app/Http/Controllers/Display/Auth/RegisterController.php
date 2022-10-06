<?php

namespace App\Http\Controllers\Display\Auth;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request) {
        $validator = $request->validate([
            'name' => 'required|regex:/^[\pL\s]+$/u',
            'userName' => 'required|regex:/^[\pL\s]+$/u|string|unique:users,username',
            'email' => 'required|unique:users',
            'country' =>'required',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'min:8',
            'gender' => 'required'
        ]);

        if ($validator) {
            return $this->userService->addUser($request);
        }

        return response()->json(['failed']);
    }
}
