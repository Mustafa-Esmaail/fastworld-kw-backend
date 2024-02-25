<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Social;

class SocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      
            // Social::create([
            //     'name'=>'facebook',
            //     'image'=>  base_path('public/uploads/socials/facebook.png')
            // ]);
            // Social::create([
            //     'name'=>'instagram',
            //     'image'=>  base_path('public/uploads/socials/Instagram_logo_2016.svg.webp')
            // ]);
            // Social::create([
            //     'name'=>'x',
            //     'image'=>  base_path('public/uploads/socials/102075304.webp')
            // ]);
            // Social::create([
            //     'name'=>'gmail',
            //     'image'=>  base_path('public/uploads/socials/gmail-icon-free-png.webp')
            // ]);
          

            Social::create([
                'name'=>'facebook',
                'image'=>  'facebook.png'
            ]);
            Social::create([
                'name'=>'instagram',
                'image'=>  'Instagram_logo_2016.svg.webp'
            ]);
            Social::create([
                'name'=>'x',
                'image'=>  '102075304.webp'
            ]);
            Social::create([
                'name'=>'gmail',
                'image'=>  'gmail-icon-free-png.webp'
            ]);
    }
}
