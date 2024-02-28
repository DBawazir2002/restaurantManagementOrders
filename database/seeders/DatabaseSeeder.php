<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        User::firstOrCreate([
            'email' => 'admin@gmail.com',
            'name' => 'admin',
            'password' =>Hash::make('adminadmin'),
            'is_admin' => true,
            'email_verified_at' => now(),
            'created_at' => Carbon::now()
        ]);
    }
}
