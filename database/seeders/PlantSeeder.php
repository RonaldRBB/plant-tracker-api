<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plant;
use Illuminate\Support\Facades\File;

class PlantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = base_path('plants.csv');
        if (File::exists($filePath)) {
            $file = fopen($filePath, 'r');
            $headers = fgetcsv($file);
            $plantsData = [];
            while ($row = fgetcsv($file)) {
                $plantsData[] = array_combine($headers, $row);
            }
            fclose($file);
            Plant::insert($plantsData);
        }
    }
}
