<?php

namespace App\Services;

use App\Models\Order;
use App\Contracts\DatabaseService;
use Exception;

class OrderStatusUpdater
{
    private DatabaseService $dbService;

    public function __construct(DatabaseService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function update(Order $order): void
    {
        try {
            $this->dbService->updateOrderStatus($order->id, $order->status, $order->priority);
        } catch (Exception $e) {
            $order->status = 'db_error';
        }
    }
}
