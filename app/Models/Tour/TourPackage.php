<?php

namespace App\Models\Tour;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination_id',
        'name',
        'uuid',
        'description',
        'price',
        'duration',
        'inclusions',
        'availability',
        'cancellation_policy',
        'refund_policy',
        'status',
    ];

    public function destination()
    {
        return $this->belongsTo(TourDestination::class, 'destination_id', 'id');
    }
}
