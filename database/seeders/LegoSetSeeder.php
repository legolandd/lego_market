<?php

namespace Database\Seeders;

use App\Models\LegoSet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class LegoSetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Получаем существующие серии и интересы
        $series = \App\Models\LegoSeries::pluck('id')->toArray();
        $interests = \App\Models\Interest::pluck('id')->toArray();

        // Создаем 50 случайных LEGO-наборов
        for ($i = 0; $i < 50; $i++) {
            $legoSet = LegoSet::create([
                'name' => 'LEGO ' . fake()->words(2, true),
                'description' => fake()->paragraph,
                'series_id' => fake()->randomElement($series),
                'price' => fake()->randomFloat(2, 10, 500),
                'recommended_age' => fake()->numberBetween(3, 18),
                'piece_count' => fake()->numberBetween(50, 3000),
                'is_new' => fake()->boolean(),
                'is_sale' => fake()->boolean(),
                'discount' => fake()->optional(0.3, 0)->numberBetween(5, 50),
                'stock' => fake()->numberBetween(0, 100),
            ]);

            // Привязываем интересы
            $legoSet->interests()->attach(fake()->randomElements($interests, fake()->numberBetween(1, 2)));

            $legoSet->images()->create(['image_url' => 'lego_images/placeholder.jpg']);
        }
    }
}
