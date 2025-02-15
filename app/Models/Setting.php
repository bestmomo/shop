<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	public $timestamps = false;

	protected $fillable = ['key', 'value', 'date1', 'date2'];

	protected function casts(): array
    {
        return [
            'date1' => 'datetime:Y-m-d',
            'date2' => 'datetime:Y-m-d',
        ];
    }
}
