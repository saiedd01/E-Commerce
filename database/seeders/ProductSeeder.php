<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('Products')->insert([
            "name"=>"HP",
            "desc"=>"Lorem ipsum may be used as a placeholder before the final copy is available.",
            "price"=>20000,
            "quantity"=>10,
            "category_id"=>2,
        ]);
    }
}
