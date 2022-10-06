<?php

namespace App\Http\Controllers\Display;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;


class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function userProfile($id) {
        return $this->userService->showUser($id);
    }

    public function create(Request $request) {
        return $this->userService->addUser($request);
    }

    public function editProfile($id, Request $request) {
        return $this->userService->updateProfile($id, $request);
    }
}
