<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BadgeCategory;

class BadgeCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'id' => 2,
                'name' => 'Food',
                'description' => '"The food you eat can be either the safest and most powerful form of medicine or the slowest form of poison." – Ann Wigmore',
                'icon' => 'icons/2vTyJy2mq43bTtDOAOglr2CavWT0mKFdAxhMB2ME.png',
            ],
            [
                'id' => 3,
                'name' => 'Sleep',
                'description' => 'Sleep is the Swiss army knife of health. When sleep is deficient, there is sickness and disease',
                'icon' => 'icons/yKWKePxHWUorw10M1XM2Lyus0aauOTIYpwZB4YrD.jpg',
            ],
            [
                'id' => 4,
                'name' => 'Hydration',
                'description' => 'The cure for anything is salt water: sweat, tears or the sea.',
                'icon' => 'icons/XcFX9gEYigsQ25LJ2FaDWUA4KUE2d7wvezjlvD5X.png',
            ],
            [
                'id' => 5,
                'name' => 'Fitness',
                'description' => 'Fitness',
                'icon' => 'icons/Nigxy9VrseolfQfPfmnKjvSyrOo78caGt3ao5KP3.webp',
            ],
            [
                'id' => 6,
                'name' => 'Habitudes',
                'description' => 'Habitudes',
                'icon' => 'icons/yGWjWk1RPsSHwajqBjChKXy21CApTdY3uZuCAEhj.webp',
            ],
        ];

        foreach ($categories as $category) {
            BadgeCategory::updateOrCreate(['id' => $category['id']], $category);
        }
    }
}
