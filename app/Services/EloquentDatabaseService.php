<?php

namespace App\Services;

use App\Contracts\DatabaseService;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class EloquentDatabaseService implements DatabaseService
{
    protected $orderModel;

    public function __construct(Order $orderModel)
    {
        $this->orderModel = $orderModel;
    }

    public function getOrdersByUser(int $userId): array
    {
        return $this->orderModel->where('user_id', $userId)->get()->all();
    }

    public function updateOrderStatus(int $orderId, string $status, string $priority): bool
    {
        try {
            return $this->orderModel->where('id', $orderId)->update([
                'status' => $status,
                'priority' => $priority,
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to update order {$orderId}: " . $e->getMessage());
            return false;
        }
    }
}
