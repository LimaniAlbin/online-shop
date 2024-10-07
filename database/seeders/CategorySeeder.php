<?php

namespace Database\Seeders;

use App\Models\CAtegory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::class::factory(5)->create();
    }
}
