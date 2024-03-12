<?php

namespace App\Facades;

use App\Services\HolidayPlanGeneratePdf;
use Illuminate\Support\Facades\Facade;

class HolidayPlanGeneratePdfFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return HolidayPlanGeneratePdf::class;
    }
}