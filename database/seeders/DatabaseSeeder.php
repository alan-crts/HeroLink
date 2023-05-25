<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $incidents = [
            "Incendie",
            "Accident routier",
            "Accident fluviale",
            "Accident aérien",
            "Eboulement",
            "Invasion de serpent",
            "Fuite de gaz",
            "Manifestation",
            "Braquage",
            "Evasion d’un prisonnier"
        ];
        foreach ($incidents as $incident) {
            \App\Models\Incident::factory()->create([
                'name' => $incident
            ]);
        }
    }
}
