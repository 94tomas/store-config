<?php

use Illuminate\Database\Seeder;

class SeederUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'thomas',
                'email' => 'thom@dev.com',
                'role' => 'seller',
                'password' => bcrypt('asdfasdf')
            ],
            [
                'name' => 'edson',
                'email' => 'ed@dev.com',
                'role' => 'user',
                'password' => bcrypt('asdfasdf')
            ]
        ]);
    }
}
