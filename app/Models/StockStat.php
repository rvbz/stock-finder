<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class StockStat extends Model
{
    use HasFactory;

    protected $hidden = ['id'];

    protected $appends = ['created_at_human'];

    protected function createdAtHuman(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => Carbon::createFromFormat('Y-m-d H:i:s', $attributes['created_at'])->format('D M jS Y'),
        );
    }
}
