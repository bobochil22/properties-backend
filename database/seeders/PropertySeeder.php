<?php

namespace Database\Seeders;

use App\Helpers\JsonEntity;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jsonEntity = new JsonEntity();
        $jsonEntity->filePath = 'seeder_data/properties.json';
        $jsonEntity->setItems();

        $jsonEntity->all()->each(function ($item) {
            
            \App\Models\Property::updateOrCreate([
                'id' => $item->id
            ],
            [
                'name'      => $item->name,
                'price'     => $item->price,
                'bedrooms'  => $item->bedrooms,
                'bathrooms' => $item->bathrooms,
                'storeys'   => $item->storeys,
                'garages'   => $item->garages,
            ]);
        });
    }
}
