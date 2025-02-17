<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Http\Requests\AuthRequest;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        parent::__construct();
    }

    public function auth(AuthRequest $request)
    {
        try {
            $token = $this->authService->attemptLogin($request->validated());
            return $this->apiResponse->success([
                'token' => $token,
                'user' => new UserResource($request->user()),
            ]);
        } catch (\Exception $e) {
            return $this->apiResponse->error($e->getMessage(), [], 401);
        }
    }
}
