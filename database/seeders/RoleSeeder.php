<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'id' => Str::uuid()->toString(),
            'role' => 'admin',
        ]);

        Role::create([
            'id' => Str::uuid()->toString(),
            'role' => 'user',
        ]);
    }
}
