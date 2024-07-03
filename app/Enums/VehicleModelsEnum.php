<?php
namespace App\Enums;

enum VehicleModelsEnum: string
{
    case Vehicle = 'vehicle';
    case VehicleModel = 'vehicle_model';
    case VehicleBrand = 'vehicle_brand';

    public function getClass(): string{
        return match ($this){
            VehicleModelsEnum::Vehicle => \App\Models\Vehicle::class,
            VehicleModelsEnum::VehicleModel => \App\Models\VehicleModel::class,
            VehicleModelsEnum::VehicleBrand => \App\Models\VehicleBrand::class
        };
    }
    public static function casesStrings(): array
    {
        $strings = [];
        foreach(self::cases() as $case) {
            $strings[] = $case->value;
        }
        return $strings;
    }
}
