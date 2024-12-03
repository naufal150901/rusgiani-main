<?php

namespace App\Models\Item;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'in_date',
        'gas_type',
        'quantity_in',
        'unit_price',
        'total_cost',
        'supplier',
        'batch_number',
        'warehouse_location',
        'additional_notes',
    ];
}
