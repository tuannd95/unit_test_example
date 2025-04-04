<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Services\OrderExporter;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderExporterTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $orderExporter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderExporter = new OrderExporter();
    }

    public function testExportOrderWithExistingDirectory()
    {
        $order = new Order(['id' => 1, 'type' => 'A', 'amount' => 100, 'flag' => true, 'status' => 'new', 'priority' => 'low']);
        $userId = 1;
        $path = storage_path('orders/orders_type_A_' . $userId . '_' . time() . '.csv');

        $result = $this->orderExporter->export($order, $userId, $path);

        $this->assertTrue($result);
        $this->assertFileExists($path);
    }

    public function testExportOrderWithNonExistingDirectory()
    {
        $order = new Order(['id' => 1, 'type' => 'A', 'amount' => 100, 'flag' => true, 'status' => 'new', 'priority' => 'low']);
        $userId = 1;
        $path = storage_path('non_existing_directory_'. time() .'/orders_type_A_' . $userId . '_' . time() . '.csv');

        $result = $this->orderExporter->export($order, $userId, $path);

        $this->assertTrue($result);
        $this->assertFileExists($path);
    }

    public function testExportOrderWithOpenFileReturnFalse()
    {
        $order = new Order(['id' => 1, 'type' => 'A', 'amount' => 100, 'flag' => true, 'status' => 'new', 'priority' => 'low']);
        $userId = 1;

        $exporterMock = $this->getMockBuilder(OrderExporter::class)
            ->onlyMethods(['openFile'])
            ->getMock();

        $exporterMock->method('openFile')->willReturn(false);

        $result = $exporterMock->export($order, $userId);

        $this->assertFalse($result);
    }

    public function testExportOrderSuccessWithFlagTrue()
    {
        $order = new Order(['id' => 1, 'type' => 'A', 'amount' => 100, 'flag' => true, 'status' => 'new', 'priority' => 'low']);
        $userId = 1;
        $path = storage_path('orders/orders_type_A_' . $userId . '_' . time() . '.csv');

        $result = $this->orderExporter->export($order, $userId, $path);

        $this->assertTrue($result);
        $this->assertFileExists($path);
    }

    public function testExportOrderSuccessWithFlagFalse()
    {
        $order = new Order(['id' => 1, 'type' => 'A', 'amount' => 100, 'flag' => false, 'status' => 'new', 'priority' => 'low']);
        $userId = 1;
        $path = storage_path('orders/orders_type_A_' . $userId . '_' . time() . '.csv');

        $result = $this->orderExporter->export($order, $userId, $path);

        $this->assertTrue($result);
        $this->assertFileExists($path);
    }

    public function testExportOrderSuccessWithAmountGreaterThan150()
    {
        $order = new Order(['id' => 1, 'type' => 'A', 'amount' => 200, 'flag' => true, 'status' => 'new', 'priority' => 'low']);
        $userId = 1;
        $path = storage_path('orders/orders_type_A_' . $userId . '_' . time() . '.csv');

        $result = $this->orderExporter->export($order, $userId, $path);

        $this->assertTrue($result);
        $this->assertFileExists($path);
    }

    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }
}
