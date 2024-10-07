<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            // 'id' => Str::uuid()->toString(),
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin123'),
        ]);
        $role = Role::where('role', 'admin')->first()->id;
        $user->roles()->sync([$role]);

        $user = User::create([
            // 'id' => Str::uuid()->toString(),
            'name' => 'user',
            'email' => 'user@user.com',
            'password' => bcrypt('admin123'),
        ]);

        $role = Role::where('role', 'user')->first()->id;
        $user->roles()->sync([$role]);
    }
}
