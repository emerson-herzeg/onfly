<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Http\Requests\AuthRequest;
use App\Http\Resources\UserResource;

/**
 * @OA\PathItem(
 *     path="/auth"
 * )
 *
 * @OA\Info(
 *  title="Login",
 *  version="1.0.0",
 * )
 *
 */
class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        parent::__construct();
    }

    /**
     * @OA\Post(
     *     path="/auth",
     *     summary="Authentication",
     *     @OA\Parameter(
     *         name="email",
     *         in="path",
     *         description="Email of the user",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *      ),
     *      @OA\Parameter(
     *         name="password",
     *         in="path",
     *         description="Password of the user",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
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
