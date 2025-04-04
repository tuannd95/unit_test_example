<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Services\OrderAPIProcessor;
use App\Contracts\APIClient;
use App\Responses\APIResponse;
use PHPUnit\Framework\TestCase;
use Mockery;
use Exception;

class OrderAPIProcessorTest extends TestCase
{
    protected $apiClient;
    protected $orderAPIProcessor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiClient = Mockery::mock(APIClient::class);
        $this->orderAPIProcessor = new OrderAPIProcessor($this->apiClient);
    }

    public function testProcessOrderApiResponseStatusNotSuccess()
    {
        $order = new Order();
        $order->id = 1;
        $order->amount = 50;
        $order->flag = false;

        $apiResponse = new APIResponse('error', 0);

        $this->apiClient->shouldReceive('callAPI')
            ->with($order->id)
            ->andReturn($apiResponse);

        $result = $this->orderAPIProcessor->process($order);

        $this->assertSame('api_error', $result);
    }

    public function testProcessOrderApiResponseDataGreaterThanOrEqual50AndAmountLessThan100()
    {
        $order = new Order();
        $order->id = 1;
        $order->amount = 50;
        $order->flag = false;

        $apiResponse = new APIResponse('success', 50);

        $this->apiClient->shouldReceive('callAPI')
            ->with($order->id)
            ->andReturn($apiResponse);

        $result = $this->orderAPIProcessor->process($order);

        $this->assertSame('processed', $result);
    }

    public function testProcessOrderApiResponseDataLessThan50()
    {
        $order = new Order();
        $order->id = 1;
        $order->amount = 50;
        $order->flag = false;

        $apiResponse = new APIResponse('success', 40);

        $this->apiClient->shouldReceive('callAPI')
            ->with($order->id)
            ->andReturn($apiResponse);

        $result = $this->orderAPIProcessor->process($order);

        $this->assertSame('pending', $result);
    }

    public function testProcessOrderApiResponseDataLessThan50AndFlagTrue()
    {
        $order = new Order();
        $order->id = 1;
        $order->amount = 50;
        $order->flag = true;

        $apiResponse = new APIResponse('success', 40);

        $this->apiClient->shouldReceive('callAPI')
            ->with($order->id)
            ->andReturn($apiResponse);

        $result = $this->orderAPIProcessor->process($order);

        $this->assertSame('pending', $result);
    }

    public function testProcessOrderApiResponseDataGreaterThanOrEqual50AndAmountGreaterThan100()
    {
        $order = new Order();
        $order->id = 1;
        $order->amount = 150;
        $order->flag = false;

        $apiResponse = new APIResponse('success', 50);

        $this->apiClient->shouldReceive('callAPI')
            ->with($order->id)
            ->andReturn($apiResponse);

        $result = $this->orderAPIProcessor->process($order);

        $this->assertSame('error', $result);
    }

    public function testProcessOrderExceptionThrown()
    {
        $order = new Order();
        $order->id = 1;
        $order->amount = 50;
        $order->flag = false;

        $this->apiClient->shouldReceive('callAPI')
            ->with($order->id)
            ->andThrow(new Exception());

        $result = $this->orderAPIProcessor->process($order);

        $this->assertSame('api_failure', $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
