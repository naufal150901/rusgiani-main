<?php

namespace App\Models\Item;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutgoingItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'out_date',
        'gas_type',
        'quantity_out',
        'unit_price',
        'total_revenue',
        'recipient',
        'shipment_number',
        'shipment_method',
        'warehouse_location',
        'shipment_status',
        'additional_notes',
    ];
}
