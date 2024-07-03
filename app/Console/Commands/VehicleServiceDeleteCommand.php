<?php

namespace App\Console\Commands;

use App\Enums\VehicleModelsEnum;
use App\Models\Vehicle;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use App\Services\VehicleService\VehicleService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VehicleServiceDeleteCommand extends Command
{
    protected $signature = 'vehicle-service:delete {model} {id?}';

    protected $description = 'Short interface for deleting vehicle-related models';

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

        $id = $this->argument('id');
        if (!$id)
            $id = $this->ask('Enter {id} (int)');
        $id = (int)$id;

        try {
            switch ($modelClass){
                case Vehicle::class:
                    VehicleService::deleteVehicle($id);
                    break;
                case VehicleModel::class:
                    VehicleService::deleteModel($id);
                    break;
                case VehicleBrand::class:
                    VehicleService::deleteBrand($id);
                    break;
                default:
                    $this->error('Wrong value is in $modelClass variable, probably it`s error in code itself');
                    return $this::FAILURE;
            }
        } catch (ModelNotFoundException $exception){
            $this->error($exception->getMessage());
            return $this::FAILURE;
        }


        $this->alert('Model was successfully deleted');
        return $this::SUCCESS;
    }
}
