<?php

namespace App\Services\VehicleService;

use App\Models\VehicleBrand;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use ArgumentCountError;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VehicleService
{
    static int $perPage = 20;

    /**
     * @throws ModelNotFoundException
     */
    public static function getBrand(int $id): VehicleBrand{
        return VehicleBrand::findOrFail($id);
    }

    /**
     * @throws ModelNotFoundException
     */
    public static function getModel(int $id): VehicleModel{
        return VehicleModel::findOrFail($id);
    }

    /**
     * @throws ModelNotFoundException
     */
    public static function getVehicle(int $id): Vehicle{
        return Vehicle::findOrFail($id);
    }

    public static function getBrands(int $page = 1, int $perPage = null): \Illuminate\Database\Eloquent\Collection{
        if (!$perPage)
            $perPage = self::$perPage;
        return VehicleBrand::offset($perPage*($page-1))->limit($perPage)->get();
    }

    public static function getModels(int $page = 1, int $perPage = null): \Illuminate\Database\Eloquent\Collection{
        if (!$perPage)
            $perPage = self::$perPage;
        return VehicleModel::offset($perPage*($page-1))->limit($perPage)->get();
    }

    public static function getVehicles(int $page = 1, int $perPage = null): \Illuminate\Database\Eloquent\Collection{
        if (!$perPage)
            $perPage = self::$perPage;
        return Vehicle::offset($perPage*($page-1))->limit($perPage)->get();
    }

    /**
     * @throws ArgumentCountError|ModelNotFoundException
     */
    public static function createVehicle(
        int|string|VehicleModel $vehicleModel,
        int|string|VehicleBrand $vehicleBrand = null,
        int $manufacture_year = null,
        int $mileage = null,
        string $color = null
    ): Vehicle{
        if (is_numeric($vehicleModel)){
            $vehicleModel = VehicleModel::findOrFail($vehicleModel);
        } elseif(is_string($vehicleModel)) {
            if ($vehicleBrand === null)
                throw new ArgumentCountError('In order to dynamically create VehicleModel specify the brand');
            $vehicleModel = self::createModel($vehicleModel, $vehicleBrand);
        }
        $model = new Vehicle();
        $model->vehicle_model_id = $vehicleModel->id;
        $model->manufacture_year = $manufacture_year;
        $model->mileage = $mileage;
        $model->color = $color;
        $model->save();
        return $model;
    }

    /**
     * @throws ModelNotFoundException
     */
    public static function createModel(string $name, string|int|VehicleBrand $brand): VehicleModel{
        if (is_numeric($brand)){
            $vehicleBrand = VehicleBrand::findOrFail($brand);
        } elseif($brand instanceof VehicleBrand) {
            $vehicleBrand = $brand;
        } else {
            $vehicleBrand = self::createBrand($brand);
        }
        $model = new VehicleModel();
        $model->vehicle_brand_id = $vehicleBrand->id;
        $model->name = $name;
        $model->save();
        return $model;
    }

    public static function createBrand(string $name): VehicleBrand{
        $model = new VehicleBrand();
        $model->name = $name;
        $model->save();
        return $model;
    }

    public static function deleteVehicle($id): void{
        Vehicle::findOrFail($id)->delete();
    }

    public static function deleteModel($id): void{
        VehicleModel::findOrFail($id)->delete();
    }

    public static function deleteBrand($id): void{
        VehicleModel::findOrFail($id)->delete();
    }

    /**
     * @throws ModelNotFoundException|ArgumentCountError
     */
    public static function updateVehicle(
        int $id,
        int|string|VehicleModel $vehicleModel,
        int|string|VehicleBrand $vehicleBrand = null,
        int $manufacture_year = null,
        int $mileage = null,
        string $color = null
    ): Vehicle{
        $model = Vehicle::findOrFail($id);
        if (is_numeric($vehicleModel)){
            $vehicleModel = VehicleModel::findOrFail($vehicleModel);
        } elseif(is_string($vehicleModel)) {
            if ($vehicleBrand === null)
                throw new ArgumentCountError('In order to dynamically create VehicleModel specify the brand');
            $vehicleModel = self::createModel($vehicleModel, $vehicleBrand);
        }
        $model->vehicle_model_id = $vehicleModel->id;
        $model->manufacture_year = $manufacture_year;
        $model->mileage = $mileage;
        $model->color = $color;
        $model->update();
        return $model;
    }
}
