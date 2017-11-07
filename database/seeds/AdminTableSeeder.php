<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    public function run()
    {
        factory(\App\User::class)->create([
            'first_name' => 'Alejandro',
            'last_name' => 'Borrell',
            'username' => 'aborrell88',
            'email' => 'aborrell88@gmail.com',
            'role' => 'admin'
        ]);
    }
}
