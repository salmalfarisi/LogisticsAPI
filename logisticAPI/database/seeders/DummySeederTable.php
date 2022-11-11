<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DummySeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('products')->truncate();
		DB::table('categories')->truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		
		DB::beginTransaction();
		for($i = 1; $i < 4; $i++)
		{
			DB::table('categories')->insert([
				'name' => 'Category Product '.$i,
				'created_at' => Carbon::now(),
			]);
			
			DB::table('products')->insert([
				'product_category_id' => $i,
				'name' => 'Product '.$i,
				'price' => rand(100000, 999999),
				'image' => 'image'.$i.'.jpg',
			]);
		}
		DB::commit();
    }
}
