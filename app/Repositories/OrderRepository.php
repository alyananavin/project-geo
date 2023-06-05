<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Config\Repository as BaseRepository;

class OrderRepository extends BaseRepository
{
    private Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->order->create($data);
    }

    public function getOrdersByUserId(int $userId)
    {
        $orders = $this->order->where('user_id', $userId)->get();
        $totalValueSum = $orders->sum('total_value');
        $result = [
            'orders' => $orders,
            'order_sum' => $totalValueSum,
        ];

        return $result;
    }
}
