<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

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

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    protected function participants(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => explode(";",$value),
            set: fn (array $value) => implode(";",$value),
        );
    }
}
