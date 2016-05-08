<?php

use App\Category;
use Illuminate\Database\Seeder;


class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        Category::create(['id' => '1', 'name' => 'Teoretická časť odbornej zložky', 'slug' => 'TCOZ']);
	    Category::create(['id' => '2', 'name' => 'Slovenský jazyk', 'slug' => 'SJL']);
	    Category::create(['id' => '3', 'name' => 'Anglický jazyk', 'slug' => 'ANJ']);
    }
}
