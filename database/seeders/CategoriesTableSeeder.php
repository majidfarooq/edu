<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('categories')->truncate();
        DB::table('categories')->insert([
            'name' => 'Uncategorized',
            'slug' => 'uncategorized',
            'parent_id' => '0',
            'description' => 'Uncategorized',
            'image' => '/public/storage/placeholder.jpg',
        ]);
    }
}
