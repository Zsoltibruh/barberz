<?php

namespace Database\Seeders;

use App\Models\OpeningHour;
use Illuminate\Database\Seeder;

class OpeningHourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $weekdays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'sunday', 'saturday'];
        foreach ($weekdays as $weekday) {
            if ($weekday === 'sunday' || $weekday === 'saturday') {
                OpeningHour::factory()
                    ->create([
                        'weekday' => $weekday,
                        'opens_at' => '00:00:00',
                        'closes_at' => '00:00:00',
                        'is_closed' => true,
                    ]);
            } else {
                OpeningHour::factory()
                    ->create([
                        'weekday' => $weekday,
                    ]);
            }
        }
    }
}
