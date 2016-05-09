<?php

use Illuminate\Database\Seeder;


class RepairStatusesTableSeeder extends Seeder
{
    public function run()
    {

	    $this->command->info('Getting all questions...');
	    $questions = \App\Question::all();
	    $this->command->info('Loaded ' . count($questions) . ' questions. Processing now...');
	    foreach ($questions as $question) {
		    $this->command->info('Processing question #' . $question->id.'...');
		    if ($question->answer_id != 0) {
			    // ok
			    $question->status = 2;
		    } else if ($question->answer_id == 0 && $question->assigned_to != 0) {
			    // waiting
			    $question->status = 1;
		    } else {
			    // not
			    $question->status = 0;
		    }
		    $question->save();
	    }
	    $this->command->info('All questions successfully updated.');

    }
}
