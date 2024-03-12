<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HolidayPlan extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'title',
        'description',
        'date',
        'location',
        'participants'
    ];

    protected function participants(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => explode(";",$value),
            set: fn (array $value) => implode(";",$value),
        );
    }
}
