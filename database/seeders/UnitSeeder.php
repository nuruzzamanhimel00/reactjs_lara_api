<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            [
                'id' => 1,
                'name' => 'Pice',
                'short_name' => 'pic',
                'base_unit_id' => null,
                'operator' => Unit::OPERATORS[0],
                'operator_value' => 1,
                'status' => Unit::STATUS_ACTIVE,
            ],
            [
                'id' => 2,
                'name' => 'KG',
                'short_name' => 'kg',
                'base_unit_id' => null,
                'operator' => Unit::OPERATORS[0],
                'operator_value' => 1,
                'status' => Unit::STATUS_ACTIVE,
            ],
            [
                'id' => 3,
                'name' => 'GRAM',
                'short_name' => 'gm',
                'base_unit_id' => 2,
                'operator' => Unit::OPERATORS[1],
                'operator_value' => 1000,
                'status' => Unit::STATUS_ACTIVE,
            ],
            [
                'id' => 4,
                'name' => 'BOX',
                'short_name' => 'box',
                'base_unit_id' => 1,
                'operator' => Unit::OPERATORS[0],
                'operator_value' => 12,
                'status' => Unit::STATUS_ACTIVE,
            ],
        ];
        foreach($units as $unit){
            Unit::updateOrCreate(['id' => $unit['id']], $unit);
        }
    }
}
