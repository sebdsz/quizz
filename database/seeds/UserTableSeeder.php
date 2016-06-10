<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \App\User::create([
            'first_name' => 'Sébastien',
            'last_name' => 'Desquirez',
            'password' => \Illuminate\Support\Facades\Hash::make('passpass'),
            'role' => 'administrator'
        ]);
    }
}
