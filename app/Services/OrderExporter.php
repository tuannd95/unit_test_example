<?php

namespace App\Services;

use App\Models\Order;

class OrderExporter
{
    /**
     * Export order details to a CSV file.
     *
     * Testcase 1: Export order with directory file is exists.
     * Testcase 2: Export order with directory file is not exists.
     * Testcase 3: Export order with open file return false.
     * Testcase 3: Export order success with flag true.
     * Testcase 4: Export order success with flag false.
     * Testcase 5: Export order success with amount > 150.
     *
     * @param Order $order
     * @param int $userId
     * @param string|null $path
     *
     * @return bool
     */
    public function export(Order $order, int $userId, string $path = null): bool
    {
        $csvFile = ($path ?? storage_path('orders/orders_type_A_' . $userId . '_' . time() . '.csv'));

        $directory = dirname($csvFile);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $fileHandle = $this->openFile($csvFile);

        if ($fileHandle === false) {
            return false;
        }

        fputcsv($fileHandle, ['ID', 'Type', 'Amount', 'Flag', 'Status', 'Priority']);
        fputcsv($fileHandle, [
            $order->id, $order->type, $order->amount, $order->flag ? 'true' : 'false', $order->status, $order->priority
        ]);

        if ($order->amount > 150) {
            fputcsv($fileHandle, ['', '', '', '', 'Note', 'High value order']);
        }

        fclose($fileHandle);
        return true;
    }

    protected function openFile(string $path)
    {
        return fopen($path, 'w');
    }
}
