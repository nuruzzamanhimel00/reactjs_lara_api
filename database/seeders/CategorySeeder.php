<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' =>1,
                'name' => 'Category 1',
                'category_type_id' => 1,
                'parent_id' => null
            ],
            [
                'id' =>2,
                'name' => 'Category 2',
                'category_type_id' => 2,
                'parent_id' => null
            ],
            [
                'id' =>3,
                'name' => 'Category 3',
                'category_type_id' => 1,
                'parent_id' => 1
            ],
            [
                'id' =>4,
                'name' => 'Category 4',
                'category_type_id' => 2,
                'parent_id' => 2
            ],
        ];

        foreach($data as $d){
            Category::updateOrCreate(['id' => $d['id']], $d);
        }
    }
}
