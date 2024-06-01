<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_model',
        'description',
        'price',
        'engine',
        'transmission',
        'color',
        'year',
        'mileage',
        'image',
        'discount',
        'featured',
        'is_new',
    ];
    public function carSpecification()
    {
        return $this->hasOne(CarSpecification::class, 'offer_id');
    }
}
