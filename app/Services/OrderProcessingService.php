<?php

namespace App\Services;

use App\Models\Order;
use App\Contracts\DatabaseService;
use App\Services\OrderExporter;
use App\Services\OrderAPIProcessor;
use App\Services\OrderStatusUpdater;
use Illuminate\Support\Facades\Log;

class OrderProcessingService
{
    private DatabaseService $dbService;
    private OrderExporter $orderExporter;
    private OrderAPIProcessor $orderAPIProcessor;
    private OrderStatusUpdater $orderStatusUpdater;

    public function __construct(
        DatabaseService $dbService,
        OrderExporter $orderExporter,
        OrderAPIProcessor $orderAPIProcessor,
        OrderStatusUpdater $orderStatusUpdater
    ) {
        $this->dbService = $dbService;
        $this->orderExporter = $orderExporter;
        $this->orderAPIProcessor = $orderAPIProcessor;
        $this->orderStatusUpdater = $orderStatusUpdater;
    }

    /**
     * Process orders for a given user.
     *
     * Testcase 1: Process orders successfully with no data.
     * Testcase 2: Process orders with a single order.
     * Testcase 3: Process orders with multiple orders.
     * Testcase 4: Process orders with an invalid user ID.
     * Testcase 5: Process orders with order type A
     * Testcase 6: Process orders with order type B
     * Testcase 7: Process orders with order type C
     * Testcase 8: Process orders with order type default
     * Testcase 9: Process orders with order type A and amount > 200
     * Testcase 10: Process orders with order type A and amount <= 200
     * Testcase 11: Process orders with order type C and flag true
     * Testcase 12: Process orders with order type C and flag false
     * Testcase 13: Process orders with order type A and export failed
     *
     *
     * @param int $userId
     * @return array|bool
     */
    public function processOrders(int $userId): array|bool
    {
        try {
            $orders = $this->dbService->getOrdersByUser($userId);

            foreach ($orders as $order) {
                $this->processOrder($order, $userId);
                $this->orderStatusUpdater->update($order);
            }

            return $orders;
        } catch (\Exception $e) {
            Log::error('Order processing failed: ' . $e->getMessage());
            return false;
        }
    }

    private function processOrder(Order $order, int $userId): void
    {
        match ($order->type) {
            'A' => $this->handleTypeA($order, $userId),
            'B' => $order->status = $this->orderAPIProcessor->process($order),
            'C' => $order->status = $order->flag ? 'completed' : 'in_progress',
            default => $order->status = 'unknown_type',
        };

        $order->priority = $order->amount > 200 ? 'high' : 'low';
    }

    private function handleTypeA(Order $order, int $userId): void
    {
        if ($this->orderExporter->export($order, $userId)) {
            $order->status = 'exported';
        } else {
            $order->status = 'export_failed';
        }
    }
}
