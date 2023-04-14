<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Log;
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
        $user = User::create([
            'username' => 'pwaldhauer',
            'email' => 'hi@pwa.io',
            'password' => Hash::make('test'),
        ]);

        Log::factory()->count(100)->create([
            'user_id' => $user->id,
        ]);
    }
}
