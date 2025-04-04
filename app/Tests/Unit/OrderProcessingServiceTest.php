<?php

namespace App\Tests\Unit;

use App\Contracts\DatabaseService;
use App\Models\Order;
use App\Services\OrderAPIProcessor;
use App\Services\OrderExporter;
use App\Services\OrderProcessingService;
use App\Services\OrderStatusUpdater;
use Illuminate\Support\Facades\Log;
use Mockery;
use PHPUnit\Framework\TestCase;

class OrderProcessingServiceTest extends TestCase
{
    protected $dbService;
    protected $orderExporter;
    protected $orderAPIProcessor;
    protected $orderStatusUpdater;
    protected $orderProcessingService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dbService = Mockery::mock(DatabaseService::class);
        $this->orderExporter = Mockery::mock(OrderExporter::class);
        $this->orderAPIProcessor = Mockery::mock(OrderAPIProcessor::class);
        $this->orderStatusUpdater = Mockery::mock(OrderStatusUpdater::class);

        $this->orderProcessingService = new OrderProcessingService(
            $this->dbService,
            $this->orderExporter,
            $this->orderAPIProcessor,
            $this->orderStatusUpdater
        );
    }

    public function testProcessOrdersSuccessfullyWithNoData()
    {
        $userId = 1;
        $this->dbService->shouldReceive('getOrdersByUser')->with($userId)->andReturn([]);

        $result = $this->orderProcessingService->processOrders($userId);

        $this->assertSame([], $result);
    }

    public function testProcessOrdersWithSingleOrder()
    {
        $userId = 1;
        $order = new Order(['type' => 'A', 'amount' => 100, 'flag' => true]);
        $this->dbService->shouldReceive('getOrdersByUser')->with($userId)->andReturn([$order]);
        $this->orderExporter->shouldReceive('export')->with($order, $userId)->andReturn(true);
        $this->orderStatusUpdater->shouldReceive('update')->with($order);

        $result = $this->orderProcessingService->processOrders($userId);

        $this->assertSame([$order], $result);
        $this->assertSame('exported', $order->status);
        $this->assertSame('low', $order->priority);
    }

    public function testProcessOrdersWithMultipleOrders()
    {
        $userId = 1;
        $order1 = new Order(['type' => 'A', 'amount' => 100, 'flag' => true]);
        $order2 = new Order(['type' => 'B', 'amount' => 300, 'flag' => false]);
        $this->dbService->shouldReceive('getOrdersByUser')->with($userId)->andReturn([$order1, $order2]);
        $this->orderExporter->shouldReceive('export')->with($order1, $userId)->andReturn(true);
        $this->orderAPIProcessor->shouldReceive('process')->with($order2)->andReturn('processed');
        $this->orderStatusUpdater->shouldReceive('update')->with($order1);
        $this->orderStatusUpdater->shouldReceive('update')->with($order2);

        $result = $this->orderProcessingService->processOrders($userId);

        $this->assertSame([$order1, $order2], $result);
        $this->assertSame('exported', $order1->status);
        $this->assertSame('low', $order1->priority);
        $this->assertSame('processed', $order2->status);
        $this->assertSame('high', $order2->priority);
    }

    public function testProcessOrdersWithInvalidUserId()
    {
        $userId = 999;
        $this->dbService->shouldReceive('getOrdersByUser')->with($userId)->andThrow(new \Exception('User not found'));

        Log::shouldReceive('error')->once()->with('Order processing failed: User not found');

        $result = $this->orderProcessingService->processOrders($userId);

        $this->assertFalse($result);
    }

    public function testProcessOrdersWithOrderTypeA()
    {
        $userId = 1;
        $order = new Order(['type' => 'A', 'amount' => 100, 'flag' => true]);
        $this->dbService->shouldReceive('getOrdersByUser')->with($userId)->andReturn([$order]);
        $this->orderExporter->shouldReceive('export')->with($order, $userId)->andReturn(true);
        $this->orderStatusUpdater->shouldReceive('update')->with($order);

        $result = $this->orderProcessingService->processOrders($userId);

        $this->assertSame([$order], $result);
        $this->assertSame('exported', $order->status);
        $this->assertSame('low', $order->priority);
    }

    public function testProcessOrdersWithOrderTypeB()
    {
        $userId = 1;
        $order = new Order(['type' => 'B', 'amount' => 100, 'flag' => true]);
        $this->dbService->shouldReceive('getOrdersByUser')->with($userId)->andReturn([$order]);
        $this->orderAPIProcessor->shouldReceive('process')->with($order)->andReturn('processed');
        $this->orderStatusUpdater->shouldReceive('update')->with($order);

        $result = $this->orderProcessingService->processOrders($userId);

        $this->assertSame([$order], $result);
        $this->assertSame('processed', $order->status);
        $this->assertSame('low', $order->priority);
    }

    public function testProcessOrdersWithOrderTypeC()
    {
        $userId = 1;
        $order = new Order(['type' => 'C', 'amount' => 100, 'flag' => true]);
        $this->dbService->shouldReceive('getOrdersByUser')->with($userId)->andReturn([$order]);
        $this->orderStatusUpdater->shouldReceive('update')->with($order);

        $result = $this->orderProcessingService->processOrders($userId);

        $this->assertSame([$order], $result);
        $this->assertSame('completed', $order->status);
        $this->assertSame('low', $order->priority);
    }

    public function testProcessOrdersWithOrderTypeDefault()
    {
        $userId = 1;
        $order = new Order(['type' => 'D', 'amount' => 100, 'flag' => true]);
        $this->dbService->shouldReceive('getOrdersByUser')->with($userId)->andReturn([$order]);
        $this->orderStatusUpdater->shouldReceive('update')->with($order);

        $result = $this->orderProcessingService->processOrders($userId);

        $this->assertSame([$order], $result);
        $this->assertSame('unknown_type', $order->status);
        $this->assertSame('low', $order->priority);
    }

    public function testProcessOrdersWithOrderTypeAAndAmountGreaterThan200()
    {
        $userId = 1;
        $order = new Order(['type' => 'A', 'amount' => 300, 'flag' => true]);
        $this->dbService->shouldReceive('getOrdersByUser')->with($userId)->andReturn([$order]);
        $this->orderExporter->shouldReceive('export')->with($order, $userId)->andReturn(true);
        $this->orderStatusUpdater->shouldReceive('update')->with($order);

        $result = $this->orderProcessingService->processOrders($userId);

        $this->assertSame([$order], $result);
        $this->assertSame('exported', $order->status);
        $this->assertSame('high', $order->priority);
    }

    public function testProcessOrdersWithOrderTypeAAndAmountLessThanOrEqualTo200()
    {
        $userId = 1;
        $order = new Order(['type' => 'A', 'amount' => 200, 'flag' => true]);
        $this->dbService->shouldReceive('getOrdersByUser')->with($userId)->andReturn([$order]);
        $this->orderExporter->shouldReceive('export')->with($order, $userId)->andReturn(true);
        $this->orderStatusUpdater->shouldReceive('update')->with($order);

        $result = $this->orderProcessingService->processOrders($userId);

        $this->assertSame([$order], $result);
        $this->assertSame('exported', $order->status);
        $this->assertSame('low', $order->priority);
    }

    public function testProcessOrdersWithOrderTypeCAndFlagTrue()
    {
        $userId = 1;
        $order = new Order(['type' => 'C', 'amount' => 100, 'flag' => true]);
        $this->dbService->shouldReceive('getOrdersByUser')->with($userId)->andReturn([$order]);
        $this->orderStatusUpdater->shouldReceive('update')->with($order);

        $result = $this->orderProcessingService->processOrders($userId);

        $this->assertSame([$order], $result);
        $this->assertSame('completed', $order->status);
        $this->assertSame('low', $order->priority);
    }

    public function testProcessOrdersWithOrderTypeCAndFlagFalse()
    {
        $userId = 1;
        $order = new Order(['type' => 'C', 'amount' => 100, 'flag' => false]);
        $this->dbService->shouldReceive('getOrdersByUser')->with($userId)->andReturn([$order]);
        $this->orderStatusUpdater->shouldReceive('update')->with($order);

        $result = $this->orderProcessingService->processOrders($userId);

        $this->assertSame([$order], $result);
        $this->assertSame('in_progress', $order->status);
        $this->assertSame('low', $order->priority);
    }

    public function testProcessOrdersWithOrderTypeAAndExportFailed()
    {
        $userId = 1;
        $order = new Order(['type' => 'A', 'amount' => 100, 'flag' => true]);
        $this->dbService->shouldReceive('getOrdersByUser')->with($userId)->andReturn([$order]);
        $this->orderExporter->shouldReceive('export')->with($order, $userId)->andReturn(false);
        $this->orderStatusUpdater->shouldReceive('update')->with($order);

        $result = $this->orderProcessingService->processOrders($userId);

        $this->assertSame([$order], $result);
        $this->assertSame('export_failed', $order->status);
        $this->assertSame('low', $order->priority);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
