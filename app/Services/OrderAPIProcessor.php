<?php

namespace App\Services;

use App\Models\Order;
use App\Contracts\APIClient;
use Exception;

class OrderAPIProcessor
{
    private APIClient $apiClient;

    public function __construct(APIClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Process the order using the API client.
     *
     * Testcase 1: Process order call API response status is not success.
     * Testcase 2: Process order call API response data >= 50 and order amount < 100.
     * Testcase 3: Process order call API response data < 50
     * Testcase 4: Process order call API response data < 50 and order flag is true.
     * Testcase 5: Process order call API response data >= 50 and amount > 100.
     * Testcase 6: Process order exception is thrown.
     *
     *
     *
     * @param Order $order
     * @return string
     */
    public function process(Order $order): string
    {
        try {
            $apiResponse = $this->apiClient->callAPI($order->id);

            if ($apiResponse->status !== 'success') {
                return 'api_error';
            }

            return match (true) {
                $apiResponse->data >= 50 && $order->amount < 100 => 'processed',
                $apiResponse->data < 50 || $order->flag => 'pending',
                default => 'error',
            };
        } catch (Exception $e) {
            return 'api_failure';
        }
    }
}
