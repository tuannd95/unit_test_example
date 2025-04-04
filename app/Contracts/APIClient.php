<?php

namespace App\Contracts;

use App\Responses\APIResponse;

interface APIClient
{
    public function callAPI(int $orderId): APIResponse;
}
