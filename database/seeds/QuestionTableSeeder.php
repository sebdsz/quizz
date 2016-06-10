<?php

use Illuminate\Database\Seeder;

class QuestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Question::create([
            'question' => 'Blabla ?',
            'answer' => 'Oui',
            'type_id' => '1',
        ]);

        \App\Question::create([
            'question' => 'Choisissez la bonne réponse',
            'answer' => 'Oui',
            'qcm_answer_1' => 'nope',
            'qcm_answer_2' => 'non',
            'qcm_answer_3' => 'nein',
            'qcm_answer_4' => 'Oui',
            'type_id' => '2',
        ]);

        \App\Question::create([
            'question' => 'Petite question ?',
            'answer' => 'Petite réponse',
            'type_id' => '1',
        ]);
    }
}
