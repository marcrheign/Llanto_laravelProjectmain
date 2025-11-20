<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Demo Player',
            'email' => 'demo@example.com',
            'password' => Hash::make('password'),
        ]);

        $platformData = [
            ['name' => 'PlayStation 5', 'manufacturer' => 'Sony', 'release_year' => 2020, 'description' => 'Sony’s flagship console with SSD architecture.'],
            ['name' => 'Xbox Series X', 'manufacturer' => 'Microsoft', 'release_year' => 2020, 'description' => 'Powerful system with Game Pass integration.'],
            ['name' => 'Nintendo Switch', 'manufacturer' => 'Nintendo', 'release_year' => 2017, 'description' => 'Hybrid handheld and docked console.'],
            ['name' => 'PC', 'manufacturer' => 'Various', 'release_year' => 2000, 'description' => 'Custom rigs for high-end gaming.'],
            ['name' => 'Steam Deck', 'manufacturer' => 'Valve', 'release_year' => 2022, 'description' => 'Handheld PC for Steam library on the go.'],
        ];

        $platforms = collect($platformData)->mapWithKeys(function ($data) {
            $platform = Platform::firstOrCreate(['name' => $data['name']], $data);
            return [$platform->name => $platform];
        });

        $gameData = [
            ['title' => 'The Legend of Zelda: Tears of the Kingdom', 'genre' => 'Adventure', 'status' => 'Playing', 'release_year' => 2023, 'platform' => 'Nintendo Switch', 'notes' => 'Exploring the Depths biome.'],
            ['title' => 'Marvel’s Spider-Man 2', 'genre' => 'Action', 'status' => 'Completed', 'release_year' => 2023, 'platform' => 'PlayStation 5', 'notes' => 'Finished main story with 100% districts.'],
            ['title' => 'Hades', 'genre' => 'Roguelike', 'status' => 'Backlog', 'release_year' => 2020, 'platform' => 'PC', 'notes' => 'Need to unlock final keepsake.'],
            ['title' => 'Forza Horizon 5', 'genre' => 'Racing', 'status' => 'Playing', 'release_year' => 2021, 'platform' => 'Xbox Series X', 'notes' => 'Working through Hot Wheels DLC.'],
            ['title' => 'Stardew Valley', 'genre' => 'Simulation', 'status' => 'Completed', 'release_year' => 2016, 'platform' => 'Steam Deck', 'notes' => 'Year 4 farm with maxed skills.'],
        ];

        foreach ($gameData as $data) {
            Game::firstOrCreate(
                ['title' => $data['title']],
                [
                    'genre' => $data['genre'],
                    'status' => $data['status'],
                    'release_year' => $data['release_year'],
                    'notes' => $data['notes'],
                    'platform_id' => optional($platforms->get($data['platform']))->id,
                ],
            );
        }
    }
}
