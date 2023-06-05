<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\UserRequest;
use OpenApi\Annotations as OA;
use Illuminate\Routing\Controller as BaseController;

class UsersController extends BaseController
{
    /**
     * UsersController __construct
     *
     * @param UserService $userService
     */
    public function __construct(protected UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Post(
     *     path="/api/user",
     *     summary="Create a new User",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="name", type="string"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created"),
     *     @OA\Response(response=403, description="Forbidden"),
     * )
     */
    public function createUser(UserRequest $userRequest)
    {
        $user = $this->userService->create($userRequest->input('data'));
        return response()->json($user, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/user/{userId}",
     *     summary="Get user by ID",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="OK"),
     * )
     */
    public function getUserById($userId)
    {
        $user = $this->userService->getById($userId);
        return response()->json($user);
    }

    /**
     * @OA\Patch(
     *     path="/api/user/{userId}",
     *     summary="Update user by ID",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="name", type="string"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Ok"),
     *     @OA\Response(response=403, description="Forbidden"),
     * )
     */
    public function updateUserById(UserRequest $userRequest, $userId)
    {
        $user = $this->userService->update($userRequest->input('data'), $userId);
        return response()->json($user, 200);
    }
}
