<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\HeroSlider;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $imageDirectory = public_path('assets/images/hero/');

        // // Get all image files from the directory
        // $imageFiles = File::files($imageDirectory);

        // foreach ($imageFiles as $imageFile) {
        //     $imageName = pathinfo($imageFile, PATHINFO_FILENAME);
        //     $imagePath = public_path('assets/images/hero/' . $imageName);

        //     HeroSlider::create([
        //         'title' => 'M75 Sport Watch',
        //         'description' => 'Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod tempor incididunt ut labore dolore magna aliqua.',
        //         'price' => '320.88',
        //         'image' => $imagePath,
        //     ]);
        // }

        HeroSlider::create([
            'title' => 'M75 Sport Watch FROM DB',
            'description' => 'Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod tempor incididunt ut labore dolore magna aliqua FROM DB.',
            'price' => '320.88',
            'image' => 'assets/images/hero/slider-bg1.jpg',
        ]);
    }
}
