<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\VehicleService\VehicleService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class VehicleModelController extends Controller
{
    public function find(Request $request, int $id)
    {
        try {
            return VehicleService::getModel($id);
        } catch (ModelNotFoundException $exception){
            return response($exception->getMessage(), 404);
        }
    }
    public function get(Request $request)
    {
        $perPage = $request->get('perPage');
        $page = $request->get('page');
        return VehicleService::getModels($page ?? 1, $perPage ?? 20);
    }
}
