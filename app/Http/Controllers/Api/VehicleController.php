<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\VehicleService\VehicleService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function get(Request $request)
    {
        $perPage = $request->get('perPage');
        $page = $request->get('page');
        return VehicleService::getVehicles($page ?? 1, $perPage ?? 20);
    }
    public function create(Request $request){
        $request->validate([
            'vehicleModel' => 'int_or_string|required',
            'vehicleBrand' => 'int_or_string|sometimes|nullable',
            'manufactureYear' => 'int|sometimes|nullable',
            'mileage' => 'int|sometimes|nullable',
            'color' => 'string|sometimes|nullable'
        ]);
        $vehicleModel = $request->get('vehicleModel');
        $vehicleBrand = $request->get('vehicleBrand');
        $manufactureYear = $request->get('manufactureYear');
        $mileage = $request->get('mileage');
        $color = $request->get('color');
        try {
            return VehicleService::createVehicle($vehicleModel, $vehicleBrand, $manufactureYear, $mileage, $color);
        } catch (\ArgumentCountError $exception){
            return response($exception->getMessage(), 400);
        }
    }
    public function update(Request $request, int $id){
        $request->validate([
            'vehicleModel' => 'int_or_string|sometimes',
            'vehicleBrand' => 'int_or_string|sometimes|nullable',
            'manufactureYear' => 'int|sometimes|nullable',
            'mileage' => 'int|sometimes|nullable',
            'color' => 'string|sometimes|nullable'
        ]);
        $vehicleModel = $request->get('vehicleModel');
        $vehicleBrand = $request->get('vehicleBrand');
        $manufactureYear = $request->get('manufactureYear');
        $mileage = $request->get('mileage');
        $color = $request->get('color');
        try {
            return VehicleService::updateVehicle($id, $vehicleModel, $vehicleBrand, $manufactureYear, $mileage, $color);
        } catch (\ArgumentCountError $exception){
            return response($exception->getMessage(), 400);
        } catch (ModelNotFoundException $exception){
            return response($exception->getMessage(), 404);
        }
    }

    public function find(Request $request, int $id)
    {
        try {
            return VehicleService::getVehicle($id);
        } catch (ModelNotFoundException $exception){
            return response($exception->getMessage(), 404);
        }
    }
    public function delete(Request $request, int $id){
        try {
            VehicleService::deleteVehicle($id);
        } catch (ModelNotFoundException $exception){
            return response($exception->getMessage(), 404);
        }
        return response('Success', 200);
    }
}
