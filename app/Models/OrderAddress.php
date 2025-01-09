<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderAddress extends Model
{
    protected $fillable = [
        'name', 
        'firstname', 
        'professionnal', 
        'civility', 
        'company', 
        'address', 
        'addressbis', 
        'bp', 
        'postal', 
        'city', 
        'phone', 
        'country_id', 
        'facturation',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
