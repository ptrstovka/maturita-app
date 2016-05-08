<?php

use Illuminate\Database\Seeder;


class SubjectTableSeeder extends Seeder
{
    public function run()
    {
        \App\Subject::create(['id' => 1, 'name' => 'Počítačové systémy', 'slug' => 'POS']);
	    \App\Subject::create(['id' => 2, 'name' => 'Elektrotechnické merania', 'slug' => 'ELM']);
	    \App\Subject::create(['id' => 3, 'name' => 'Ekonomika', 'slug' => 'EKO']);
	    \App\Subject::create(['id' => 4, 'name' => 'Sieťové technológie', 'slug' => 'SIE']);
	    \App\Subject::create(['id' => 5, 'name' => 'Výpočtová technika', 'slug' => 'VYT']);
	    \App\Subject::create(['id' => 6, 'name' => 'Databázové aplikácie', 'slug' => 'DAA']);
	    \App\Subject::create(['id' => 7, 'name' => 'Elektronika', 'slug' => 'ELE']);
	    \App\Subject::create(['id' => 8, 'name' => 'Slovenský jazyk', 'slug' => 'SJL']);
	    \App\Subject::create(['id' => 9, 'name' => 'Anglický jazyk', 'slug' => 'ANJ']);
    }
}
