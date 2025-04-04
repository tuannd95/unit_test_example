<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Services\EloquentDatabaseService;
use Illuminate\Support\Facades\Log;
use Mockery;
use PHPUnit\Framework\TestCase;

class EloquentDatabaseServiceTest extends TestCase
{
    protected $databaseService;

    protected function setUp(): void
    {
        parent::setUp();
        $orderMock = Mockery::mock(Order::class);
        $this->databaseService = new EloquentDatabaseService($orderMock);
    }

    public function testGetOrdersByUser()
    {
        $userId = 1;
        $orders = [
            new Order(['id' => 1, 'user_id' => $userId, 'status' => 'pending']),
            new Order(['id' => 2, 'user_id' => $userId, 'status' => 'processed']),
        ];

        $orderMock = Mockery::mock(Order::class);
        $orderMock->shouldReceive('where')->with('user_id', $userId)->andReturnSelf();
        $orderMock->shouldReceive('get')->andReturn(collect($orders));

        $service = new EloquentDatabaseService($orderMock);
        $result = $service->getOrdersByUser($userId);

        $this->assertEquals($orders, $result);
    }

    public function testUpdateOrderStatusSuccess()
    {
        $orderId = 1;
        $status = 'processed';
        $priority = 'high';

        $orderMock = Mockery::mock(Order::class);
        $orderMock->shouldReceive('where')->with('id', $orderId)->andReturnSelf();
        $orderMock->shouldReceive('update')->with(['status' => $status, 'priority' => $priority])->andReturn(true);

        $service = new EloquentDatabaseService($orderMock);
        $result = $service->updateOrderStatus($orderId, $status, $priority);

        $this->assertTrue($result);
    }

    public function testUpdateOrderStatusFailure()
    {
        $orderId = 1;
        $status = 'processed';
        $priority = 'high';

        $orderMock = Mockery::mock(Order::class);
        $orderMock->shouldReceive('where')->with('id', $orderId)->andReturnSelf();
        $orderMock->shouldReceive('update')->with(['status' => $status, 'priority' => $priority])->andThrow(new \Exception('Database error'));

        Log::shouldReceive('error')->once()->with("Failed to update order {$orderId}: Database error");

        $service = new EloquentDatabaseService($orderMock);
        $result = $service->updateOrderStatus($orderId, $status, $priority);

        $this->assertFalse($result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
