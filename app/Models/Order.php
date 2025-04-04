<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['type', 'amount', 'flag', 'status', 'priority'];

    protected $attributes = [
        'status' => 'new',
        'priority' => 'low',
    ];
}
