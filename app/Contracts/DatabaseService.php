<?php

namespace App\Contracts;

interface DatabaseService
{
    public function getOrdersByUser(int $userId): array;
    public function updateOrderStatus(int $orderId, string $status, string $priority): bool;
}
