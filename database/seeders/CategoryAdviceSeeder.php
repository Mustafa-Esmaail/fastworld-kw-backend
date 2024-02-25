<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category_Advice;
use App\Models\Advice;

class CategoryAdviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Category1=Category_Advice::create([
            'title'         =>  'Category1',
        ]);
        Advice::create([
            'title'         => 'Advice1',
            'url'          => 'https://www.youtube.com/watch?v=9DDe6Zr34YU&ab_channel=Alafasy',
            'category_id'          =>  $Category1->id,
        ]);
        Advice::create([
            'title'         => 'Advice2',
            'url'          => 'https://www.youtube.com/watch?v=9DDe6Zr34YU&ab_channel=Alafasy',
            'category_id'          =>  $Category1->id,
        ]);
        Advice::create([
            'title'         => 'Advice3',
            'url'          => 'https://www.youtube.com/watch?v=9DDe6Zr34YU&ab_channel=Alafasy',
            'category_id'          =>  $Category1->id,
        ]);
        $Category2= Category_Advice::create([
            'title'         =>  'Category2',
        ]);
        Advice::create([
            'title'         => 'Advice1',
            'url'          => 'https://www.youtube.com/watch?v=9DDe6Zr34YU&ab_channel=Alafasy',
            'category_id'          =>  $Category2->id,
        ]);
        Advice::create([
            'title'         => 'Advice2',
            'url'          => 'https://www.youtube.com/watch?v=9DDe6Zr34YU&ab_channel=Alafasy',
            'category_id'          =>  $Category2->id,
        ]);
        Advice::create([
            'title'         => 'Advice3',
            'url'          => 'https://www.youtube.com/watch?v=9DDe6Zr34YU&ab_channel=Alafasy',
            'category_id'          =>  $Category2->id,
        ]);
        $Category3=  Category_Advice::create([
            'title'         =>  'Category3',
        ]);
        Advice::create([
            'title'         => 'Advice1',
            'url'          => 'https://www.youtube.com/watch?v=9DDe6Zr34YU&ab_channel=Alafasy',
            'category_id'          =>  $Category3->id,
        ]);
        Advice::create([
            'title'         => 'Advice2',
            'url'          => 'https://www.youtube.com/watch?v=9DDe6Zr34YU&ab_channel=Alafasy',
            'category_id'          =>  $Category3->id,
        ]);
        Advice::create([
            'title'         => 'Advice3',
            'url'          => 'https://www.youtube.com/watch?v=9DDe6Zr34YU&ab_channel=Alafasy',
            'category_id'          =>  $Category3->id,
        ]);
        $Category4=  Category_Advice::create([
            'title'         =>  'Category4',
        ]);
        Advice::create([
            'title'         => 'Advice1',
            'url'          => 'https://www.youtube.com/watch?v=9DDe6Zr34YU&ab_channel=Alafasy',
            'category_id'          =>  $Category4->id,
        ]);
        Advice::create([
            'title'         => 'Advice2',
            'url'          => 'https://www.youtube.com/watch?v=9DDe6Zr34YU&ab_channel=Alafasy',
            'category_id'          =>  $Category4->id,
        ]);
        Advice::create([
            'title'         => 'Advice3',
            'url'          => 'https://www.youtube.com/watch?v=9DDe6Zr34YU&ab_channel=Alafasy',
            'category_id'          =>  $Category4->id,
        ]);
        $Category5=   Category_Advice::create([
            'title'         =>  'Category5',
        ]);
        Advice::create([
            'title'         => 'Advice1',
            'url'          => 'https://www.youtube.com/watch?v=9DDe6Zr34YU&ab_channel=Alafasy',
            'category_id'          =>  $Category5->id,
        ]);
        Advice::create([
            'title'         => 'Advice2',
            'url'          => 'https://www.youtube.com/watch?v=9DDe6Zr34YU&ab_channel=Alafasy',
            'category_id'          =>  $Category5->id,
        ]);
        Advice::create([
            'title'         => 'Advice3',
            'url'          => 'https://www.youtube.com/watch?v=9DDe6Zr34YU&ab_channel=Alafasy',
            'category_id'          =>  $Category5->id,
        ]);
        $Category6=  Category_Advice::create([
            'title'         =>  'Category6',
        ]);
    }
}
