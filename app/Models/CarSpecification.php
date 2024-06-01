<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarSpecification extends Model
{
    use HasFactory;

    protected $fillable = [
        'offer_id', 'engine', 'transmission', 'color', 'year', 'mileage'
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
