<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Services\OrderStatusUpdater;
use App\Contracts\DatabaseService;
use Exception;
use PHPUnit\Framework\TestCase;
use Mockery;

class OrderStatusUpdaterTest extends TestCase
{
    protected $dbService;
    protected $orderStatusUpdater;

    protected function setUp(): void
    {
        parent::setUp();
        $this->dbService = Mockery::mock(DatabaseService::class);
        $this->orderStatusUpdater = new OrderStatusUpdater($this->dbService);
    }

    public function testUpdateOrderStatusSuccessfully()
    {
        $order = new Order();
        $order->id = 1;
        $order->status = 'processed';
        $order->priority = 'high';

        $this->dbService->shouldReceive('updateOrderStatus')
            ->with($order->id, $order->status, $order->priority)
            ->andReturn(true);

        $this->orderStatusUpdater->update($order);

        $this->assertSame('processed', $order->status);
    }

    public function testUpdateOrderStatusWithDatabaseException()
    {
        $order = new Order();
        $order->id = 1;
        $order->status = 'processed';
        $order->priority = 'high';

        $this->dbService->shouldReceive('updateOrderStatus')
            ->with($order->id, $order->status, $order->priority)
            ->andThrow(new Exception());

        $this->orderStatusUpdater->update($order);

        $this->assertSame('db_error', $order->status);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
