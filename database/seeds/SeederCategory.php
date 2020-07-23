<?php

use Illuminate\Database\Seeder;

class SeederCategory extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Monitores', 'description' => 'descripcion monitores'],
            ['name' => 'Teclados', 'description' => 'descripcion teclados'],
            ['name' => 'Mouses', 'description' => 'descripcion mouses'],
            ['name' => 'Cables USB', 'description' => 'descripcion cables'],
            ['name' => 'Impresoras', 'description' => 'descripcion impresoras']
        ]);
    }
}
