<?php

namespace App\Models\Tour;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourDestination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'uuid',
        'slug',
        'description',
        'location',
        'maps',
        'operating_days',
        'opening_hours',
        'closing_hours',
        'images',
        'status',
    ];

    protected $casts = [
        'images' => 'array',
        'operating_days' => 'array',
    ];

    public function packages()
    {
        return $this->hasMany(TourPackage::class, 'destination_id', 'id');
    }
}
