<?php

namespace App\Console\Commands;

use App\Models\Vehicle;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use Illuminate\Console\Command;
use App\Enums\VehicleModelsEnum;
use Illuminate\Database\Eloquent\Model;
use App\Services\VehicleService\VehicleService;

class VehicleServiceCreateCommand extends Command
{
    protected $signature = 'vehicle-service:create {model}';

    protected $description = 'Short interface for creating vehicle-related models';

    public function handle()
    {
        $modelClass = VehicleModelsEnum::tryFrom($this->argument('model'));
        if ($modelClass === null){
            $this->alert(
                'No such model exists'
            );
            $this->warn('Try these:'.PHP_EOL.implode(PHP_EOL, VehicleModelsEnum::casesStrings()));
            return $this::INVALID;
        }
        $modelClass = $modelClass->getClass();

        $this->info('Creating '.$modelClass.' object:');
        $model = null;

        if ($modelClass == VehicleBrand::class || $modelClass == VehicleModel::class){
            $name = $this->ask('Enter {name} parameter');
        }
        if ($modelClass == VehicleBrand::class){
            $model = VehicleService::createBrand($name);
        }
        if ($modelClass == VehicleModel::class){
            $vehicleBrand = $this->getVehicleBrand();
            $model = VehicleService::createModel($name, $vehicleBrand);
        }
        if ($modelClass == Vehicle::class){
            $vehicleBrand = null;
            $vehicleModel = $this->ask('Enter {model} parameter (int|string)');
            if (is_numeric($vehicleModel)){
                $vehicleModel = VehicleService::getModel((int)$vehicleModel);
            } else {
                $vehicleBrand = $this->getVehicleBrand();
                $vehicleModel = VehicleService::createModel($vehicleModel, $vehicleBrand);
            }
            $manufactureYear = $this->ask('Enter {manufacture year} (press Enter to skip.)');
            $mileage = $this->ask('Enter {mileage} (press Enter to skip.)');
            $color = $this->ask('Enter {color} (press Enter to skip.)');
            $model = VehicleService::createVehicle($vehicleModel, $vehicleBrand, $manufactureYear, $mileage, $color);
        }
        $this->alert('Model was created successfully');
        dump($model);
        return $this::SUCCESS;
    }

    protected function getVehicleBrand(): VehicleBrand{
        $vehicleBrand = $this->ask('Enter {brand} parameter (int|string)');
        if (is_numeric($vehicleBrand)){
            $vehicleBrand = VehicleService::getBrand((int)$vehicleBrand);
        } else {
            $vehicleBrand = VehicleService::createBrand($vehicleBrand);
        }
        return $vehicleBrand;
    }
}
