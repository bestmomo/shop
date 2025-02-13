<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 
        'price', 
        'quantity', 
        'weight', 
        'active', 
        'quantity_alert', 
        'image', 
        'description',
        'promotion_price',
        'promotion_start_date',
        'promotion_end_date',
    ];

    protected function casts(): array
    {
        return [
            'promotion_start_date' => 'datetime:d-m-Y',
            'promotion_end_date' => 'datetime:d-m-Y',
        ];
    }
}
