<?php

use Illuminate\Database\Seeder;

class SeederProduct extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'test 1',
                'description' => '<p>description</p>',
                'banner' => 'test.jpg',
                'stock' => 10,
                'price' => 1125,
                'discount' => 125,
                'publish' => true,
                'slug' => 'test-1',
                'category_id' => 2
            ],
            [
                'name' => 'test vans',
                'description' => '<p>description</p>',
                'banner' => 'test.jpg',
                'stock' => 10,
                'price' => 1125,
                'discount' => 125,
                'publish' => true,
                'slug' => 'test-vans',
                'category_id' => 3
            ],
            [
                'name' => 'test 2',
                'description' => '<p>description</p>',
                'banner' => 'test.jpg',
                'stock' => 10,
                'price' => 1125,
                'discount' => 125,
                'publish' => true,
                'slug' => 'test-2',
                'category_id' => 2
            ],
            [
                'name' => 'test seeder',
                'description' => '<p>description</p>',
                'banner' => 'test.jpg',
                'stock' => 10,
                'price' => 1125,
                'discount' => 125,
                'publish' => true,
                'slug' => 'test-seeder',
                'category_id' => 1
            ],
            [
                'name' => 'test',
                'description' => '<p>description</p>',
                'banner' => 'test.jpg',
                'stock' => 10,
                'price' => 1125,
                'discount' => 125,
                'publish' => true,
                'slug' => 'test',
                'category_id' => 4
            ],
            [
                'name' => 'Skate',
                'description' => '<p>description</p>',
                'banner' => 'test.jpg',
                'stock' => 10,
                'price' => 1125,
                'discount' => 125,
                'publish' => true,
                'slug' => 'skate',
                'category_id' => 2
            ],
            [
                'name' => 'sk8 black',
                'description' => '<p>description</p>',
                'banner' => 'test.jpg',
                'stock' => 10,
                'price' => 2000,
                'discount' => 0,
                'publish' => true,
                'slug' => 'sk8-black',
                'category_id' => 2
            ],
            [
                'name' => 'test 3',
                'description' => '<p>description</p>',
                'banner' => 'test.jpg',
                'stock' => 10,
                'price' => 1125,
                'discount' => 125,
                'publish' => true,
                'slug' => 'test-3',
                'category_id' => 2
            ],
            [
                'name' => 'test 4',
                'description' => '<p>description</p>',
                'banner' => 'test.jpg',
                'stock' => 10,
                'price' => 1125,
                'discount' => 125,
                'publish' => true,
                'slug' => 'test-4',
                'category_id' => 2
            ],
            [
                'name' => 'test 5',
                'description' => '<p>description</p>',
                'banner' => 'test.jpg',
                'stock' => 10,
                'price' => 1125,
                'discount' => 125,
                'publish' => true,
                'slug' => 'test-5',
                'category_id' => 2
            ],
        ]);
    }
}
