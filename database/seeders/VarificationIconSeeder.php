<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VarificationIcon;

class VarificationIconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VarificationIcon::create([ 
            'name'=>'true',
            'icon'=>  'true.PNG'
        ]);

        VarificationIcon::create([ 
            'name'=>'trueblue',
            'icon'=>  'trueblue.PNG'
        ]);

        VarificationIcon::create([ 
            'name'=>'truebluecircle',
            'icon'=>  'truebluecircle.PNG'
        ]);

        VarificationIcon::create([ 
            'name'=>'truegreen',
            'icon'=>  'truegreen.PNG'
        ]);
    }
}
