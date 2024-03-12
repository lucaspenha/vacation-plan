<?php


namespace App\Services;

use App\Models\HolidayPlan;
use stdClass;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HolidayPlanGeneratePdf
{
    public function generate(HolidayPlan $holidayPlan)
    {
        Storage::makeDirectory("holiday-plans");
        $pdf = Pdf::loadView('pdf.holiday-plan',[ 'data' => $holidayPlan ]);
        return $pdf;
    }

    public function make(HolidayPlan $holidayPlan): stdClass
    {
        Storage::makeDirectory("holiday-plans");
        $path = "holiday-plans/" . Str::uuid().'.pdf';
        $this->generate($holidayPlan)->save(Storage::path($path));
        
        return (object) [
            'url' => Storage::url($path)
        ];
    }
}