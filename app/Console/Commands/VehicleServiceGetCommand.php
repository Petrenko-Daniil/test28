<?php

namespace App\Console\Commands;

use App\Enums\VehicleModelsEnum;
use App\Models\Vehicle;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use App\Services\VehicleService\VehicleService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VehicleServiceGetCommand extends Command
{
    protected $signature = 'vehicle-service:get {model} {page=1} {per_page?}';

    protected $description = 'Short interface for getting vehicle-related collections';

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
        switch ($modelClass){
            case Vehicle::class:
                $collection = VehicleService::getVehicles(
                    $this->argument('page'),
                    $this->argument('per_page')
                );
                break;
            case VehicleModel::class:
                $collection = VehicleService::getModels(
                    $this->argument('page'),
                    $this->argument('per_page')
                );
                break;
            case VehicleBrand::class:
                $collection = VehicleService::getBrands(
                    $this->argument('page'),
                    $this->argument('per_page')
                );
                break;
            default:
                $this->error('Wrong value is in $modelClass variable, probably it`s error in code itself');
                return $this::FAILURE;
        }


        $this->alert('Collection data: ');
        dump($collection);
        return $this::SUCCESS;
    }
}
