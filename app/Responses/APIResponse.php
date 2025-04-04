<?php

namespace App\Responses;

use App\Models\Order;

class APIResponse
{
    public string $status;
    public mixed $data;

    public function __construct(string $status, mixed $data)
    {
        $this->status = $status;
        $this->data = $data;
    }
}
