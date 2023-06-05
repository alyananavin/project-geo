<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use App\Http\Requests\OrderRequest;
use OpenApi\Annotations as OA;
use Illuminate\Routing\Controller as BaseController;

class OrderController extends BaseController
{
    /**
     * OrderController __construct
     *
     * @param OrderService $orderService
     */
    public function __construct(protected OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @OA\Post(
     *     path="/api/order",
     *     summary="Create a new Order",
     *     tags={"Order"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="total_value", type="number"),
     *                 @OA\Property(property="date", type="string", format="date"),
     *                 @OA\Property(property="user_id", type="integer"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created"),
     *     @OA\Response(response=403, description="Forbidden"),
     * )
     */
    public function createOrder(OrderRequest $orderRequest)
    {
        $order = $this->orderService->create($orderRequest->input('data'));
        return response()->json($order, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/order/user/{userId}",
     *     summary="Get user orders by user ID",
     *     tags={"Order"},
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
    public function getUserOrders(int $userId)
    {
        $userOrders = $this->orderService->getOrdersByUserId($userId);
        return response()->json($userOrders);
    }
}
