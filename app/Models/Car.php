<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
        'price_per_day',
        'availability_status',
        'image',
    ];

    /**
     * The orders that belong to the car.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
