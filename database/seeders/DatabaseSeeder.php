<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\customers;
use App\Models\User;
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

        customers::query()->create([
            'name'=> 'Omar Mahgoub',
            'password' =>bcrypt('123456'),
            'email'=> 'omar@gmail.com'
        ]);

        // $this->call(AllDataSeeder::class);
    }
}
