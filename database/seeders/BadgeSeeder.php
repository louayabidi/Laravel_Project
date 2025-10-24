<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Badge;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        $badges = [
            ['id' => 5, 'name' => 'Healthy Eater', 'description' => 'Protect your health and eat healthy for 3 days', 'image' => 'badges/YRiJTKbU4W6kn0YINCgw2jmrRAc6J8I2uNPtjY3p.webp', 'criteria' => 30, 'badge_categorie_id' => 2],
            ['id' => 6, 'name' => 'Low Calorie Consumer', 'description' => 'Eat dishes less then 50 calories a day', 'image' => 'badges/NfooUj0DcMVwJoRlz5b3yA3TleO5PobrUekYaHLV.webp', 'criteria' => 10, 'badge_categorie_id' => 2],
            ['id' => 7, 'name' => 'Balanced Diet', 'description' => 'Eat dishes full of protein carbs and fats', 'image' => 'badges/uW8KC3XAPfJSEl0OZA8RDv5TIWCbSa2DEXN2yTjG.webp', 'criteria' => 10, 'badge_categorie_id' => 2],
            ['id' => 8, 'name' => 'Sugar Watcher', 'description' => 'Eat meals with low sugar', 'image' => 'badges/eHVWiftp4Je1pDhMYaN7Ygk1EZKukUDL0nhBjjlu.webp', 'criteria' => 10, 'badge_categorie_id' => 2],
            ['id' => 9, 'name' => 'Sugar Free', 'description' => 'Eat sugar free for a while', 'image' => 'badges/UmJyP67DzfEmDWPufJau5qgr6iwi8Zb8A0x6qOAO.webp', 'criteria' => 10, 'badge_categorie_id' => 2],
            ['id' => 10, 'name' => 'Fiber Fanatic', 'description' => 'Fiber is very good for your health eat it so you can acheive this badge', 'image' => 'badges/Yfgp3cuIYNh6T97biRA4hBZI1RrG8ikhp9EVrzx8.webp', 'criteria' => 10, 'badge_categorie_id' => 2],
            ['id' => 11, 'name' => 'Early Riser', 'description' => 'Sleep between 6 and 8 hours a day', 'image' => 'badges/Vkbd2ah5HOHDQS6i6ico7E0LXqVvZmkJKPTTsAw9.png', 'criteria' => 10, 'badge_categorie_id' => 3],
            ['id' => 12, 'name' => 'Sleep Tracker', 'description' => 'Sleep regulary for a week between 6 and 8 hours a day', 'image' => 'badges/EKiTGal19m2LlstApTTT47thfUEIlDpGHv0viv4Y.png', 'criteria' => 10, 'badge_categorie_id' => 3],
            ['id' => 13, 'name' => 'Hydration Starter', 'description' => '1–1.5 L of water a day', 'image' => 'badges/fs7F9sGOTkWcpEo1mvhp9sdU958UVbuyQYGfIxR0.png', 'criteria' => 10, 'badge_categorie_id' => 4],
            ['id' => 14, 'name' => 'Water Warrior', 'description' => '2–2.5 L of water', 'image' => 'badges/gjv1Ij3X2W6VmBjCsPrmWsLGQeD8cNx9ubwBh3T0.png', 'criteria' => 10, 'badge_categorie_id' => 4],
            ['id' => 15, 'name' => 'Hydration Hero', 'description' => '3+ L of water', 'image' => 'badges/NURDvXORUFSKEN23M9T3PIafF7V04kAoMBqAKl8m.png', 'criteria' => 10, 'badge_categorie_id' => 4],
            ['id' => 16, 'name' => 'Active Starter', 'description' => '15–30 minutes of sport a day', 'image' => 'badges/Q1QJMLgGGMfZDYKA5SA0CTWao0QYQ9CzG8KR1C7X.webp', 'criteria' => 10, 'badge_categorie_id' => 5],
            ['id' => 17, 'name' => 'Fitness Fan', 'description' => '30–60 minutes', 'image' => 'badges/LaXb10Sg7979Be0gJMq7AQQqkyVPzKgfjWoVf6NB.jpg', 'criteria' => 10, 'badge_categorie_id' => 5],
            ['id' => 18, 'name' => 'Endurance Pro', 'description' => '60+ minutes a day', 'image' => 'badges/CyiS9mbtlkFZuIaUP2cl0ga2iTFRhvXihTSFD1dP.jpg', 'criteria' => 10, 'badge_categorie_id' => 5],
            ['id' => 19, 'name' => 'Calm Mind', 'description' => 'Keep your stress level low', 'image' => 'badges/ky5HL9a755Dw8ncaRrgz83k0kYO57aphWIWaclLb.webp', 'criteria' => 10, 'badge_categorie_id' => 6],
            ['id' => 20, 'name' => 'Mindful Starter', 'description' => 'Try to practice some meditation for more then 10 minutes a day to keep your mind clear', 'image' => 'badges/K1vdkfZVmhldGNspyn69JYD57LyRDctJzIRbOaZ8.webp', 'criteria' => 10, 'badge_categorie_id' => 6],
            ['id' => 21, 'name' => 'Zen Master', 'description' => 'Try to practice some meditation for more then 30 minutes a day', 'image' => 'badges/mdcxAU8hbnzm1eoDlT89EHkJCITj40RkaKY7xYe6.webp', 'criteria' => 10, 'badge_categorie_id' => 6],
            ['id' => 22, 'name' => 'Digital Detox', 'description' => 'Avoid using your device for a long time', 'image' => 'badges/UMU7X3C8Yq5Xpv3xGmJankOsl4ZrYjTmkqIW91FP.webp', 'criteria' => 10, 'badge_categorie_id' => 6],
            ['id' => 23, 'name' => 'Balanced Energy', 'description' => 'Avoid drinking more than 2 cups of coffee a day', 'image' => 'badges/6H33tROUJozyRrMYpqmqMTlZ8AyymXokjU7b0rqL.webp', 'criteria' => 10, 'badge_categorie_id' => 6],
        ];

        foreach ($badges as $badge) {
            Badge::updateOrCreate(['id' => $badge['id']], $badge);
        }
    }
}
