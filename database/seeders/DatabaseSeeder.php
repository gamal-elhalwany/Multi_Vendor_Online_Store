<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\Category;
use App\Models\HeroSlider;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        // Admin::factory(3)->create();
        // Store::factory(5)->create();
        // Category::factory(10)->create();
        // Product::factory(100)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'gamal el_halwany',
        //     'email' => 'g@all.com',
        //     'password' => Hash::make('00000000'),
        //     'phone_number' => '01234567891',
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'youssef gamal',
        //     'email' => 'y@g.com',
        //     'password' => Hash::make('00000000'),
        //     'phone_number' => '01234567892',
        // ]);

        // HeroSlider::factory(3)->create();
    }
}
