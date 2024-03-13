<?php

namespace App\Http\Controllers\Api;

use App\Facades\HolidayPlanGeneratePdfFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\HolidayPlanStoreRequest;
use App\Http\Requests\Api\HolidayPlanUpdateRequest;
use App\Http\Resources\HolidayPlanCollection;
use App\Http\Resources\HolidayPlanResource;
use App\Models\HolidayPlan;
use Symfony\Component\HttpFoundation\Response;

class HolidayPlanController extends Controller
{
    public function index()
    {
        $holidays = HolidayPlan::all();

        if(!$holidays->count())
            return $this->responseWithSuccess('No results yet', [[]], Response::HTTP_NO_CONTENT);

        return $this->responseWithSuccess('Ok', 
            HolidayPlanCollection::make($holidays)
        , Response::HTTP_OK);
    }

    public function store(HolidayPlanStoreRequest $request)
    {
        $data = HolidayPlan::create($request->all());

        return $this->responseWithSuccess('Holiday Plan created successfully', [
            HolidayPlanResource::make($data)
        ], Response::HTTP_CREATED);
    }

    public function show($holidayPlan)
    {
        if(!$holidayPlan = HolidayPlan::whereUuid($holidayPlan)->first())
            return $this->responseWithError('Holiday plan not found',[],Response::HTTP_NOT_FOUND);

        return $this->responseWithSuccess('Ok', 
            HolidayPlanResource::make($holidayPlan)
        , Response::HTTP_OK);
    }

    public function update(HolidayPlanUpdateRequest $request, $id)
    {
        if(!$holidayPlan = HolidayPlan::whereUuid($id)->first())
            return $this->responseWithError('Holiday plan not found',[],Response::HTTP_NOT_FOUND);

        if(!$request->all()) 
            return $this->responseWithError('the request body is empty',[],Response::HTTP_BAD_REQUEST);

        $holidayPlan->fill($request->all())->save();

        return $this->responseWithSuccess('Holiday Plan updated successfully',
            HolidayPlanResource::make($holidayPlan)
        , Response::HTTP_OK);
    }

    public function destroy($id)
    {
        if(!$holidayPlan = HolidayPlan::whereUuid($id)->first())
            return $this->responseWithError('Holiday plan not found',[], Response::HTTP_NOT_FOUND);

        $holidayPlan->delete();

        return $this->responseWithSuccess('Holiday Plan deleted successfully',[], Response::HTTP_NO_CONTENT);
    }

    public function pdf($id){

        if(!$holidayPlan = HolidayPlan::whereUuid($id)->first())
            return $this->responseWithError('Holiday plan not found',[], Response::HTTP_NOT_FOUND);

            try {
                $pdf = HolidayPlanGeneratePdfFacade::make($holidayPlan);
            } catch (\Throwable $th) {
                return $this->responseWithError('It was not possible to generate the pdf file, please contact us',[], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

        return $this->responseWithSuccess('Holiday Plan PDF create successfully',[
            'link_pdf' => $pdf->url,
            'holiday_plan' => HolidayPlanResource::make($holidayPlan)
        ], Response::HTTP_OK);
    }
}
