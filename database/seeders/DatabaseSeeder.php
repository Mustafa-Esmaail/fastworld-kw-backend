<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Owner;
use App\Models\Setting;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(LaratrustSeeder::class);
        $this->call(CategoryAdviceSeeder::class);
        // $this->call(SocialSeeder::class);
        $this->call(SocialIconSeeder::class);
        
        Category::create([
            'name'=>'animation',
        ]);
        Category::create([
            'name'=>'online store',
        ]);
        $owner = Owner::create([
            'email'            =>'ahmed@gmail.com',
            'password'         => bcrypt(12345678),
            'verify_account'=>true,
            // "device_token"     => $request->device_token,
            // 'avater'        => $request->avater != null ? self::uploadImage($request->file('avater'),'owners') : null,
        ]);
        $set=Setting::create([
                        
            'remove_brand'            => 0,
            'owner_id'                =>$owner->id,
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
