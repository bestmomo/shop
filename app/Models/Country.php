<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    protected $fillable = [
        'name', 
        'tax',
    ];

    public $timestamps = false;

    public function ranges(): BelongsToMany
    {
        return $this->belongsToMany(Range::class, 'colissimos')->withPivot('id', 'price');
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function order_addresses(): HasMany
    {
        return $this->hasMany(OrderAddress::class);
    }
}
