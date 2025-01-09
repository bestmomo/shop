<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Range extends Model
{
    protected $fillable = [ 'max', ];
    
    public $timestamps = false;

    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class, 'colissimos')->withPivot('price');
    }
}
