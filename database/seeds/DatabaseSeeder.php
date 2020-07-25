<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SeederUser::class);
        $this->call(SeederCategory::class);
        $this->call(SeederProduct::class);
    }
}
