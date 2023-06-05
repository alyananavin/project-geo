<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\OrderRepository;

/**
 * Class OrderService.
 *
 * @package App\Services
 */
class OrderService
{
    /**
     * Order Service constructor.
     * @param OrderRepository $orderRepository
     */
    public function __construct(protected OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Create new order data.
     *
     * @param array $data
     * @return \App\Models\Order Order Model
     */
    public function create(array $data = []): Order|bool|null
    {
        return $this->orderRepository->create($data);
    }

    /**
     * Get all orders by userID
     *
     * @param int $userId
     * @return array Order array
     */
    public function getOrdersByUserId(int $userId): array
    {
        return $this->orderRepository->getOrdersByUserId($userId);
    }
}
