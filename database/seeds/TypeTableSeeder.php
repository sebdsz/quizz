<?php

use Illuminate\Database\Seeder;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \App\Type::create([
            'name' => 'question',
        ]);

        \App\Type::create([
            'name' => 'qcm',
        ]);
    }
}
