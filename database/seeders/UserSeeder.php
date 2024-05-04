<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $employeeRole = Role::firstOrCreate(['name' => 'Employee']);
        $adminUser = User::create([
            'name'=>'Gerson Ruano',
            'phone'=>'23423424',
            'email'=>'toge619@gmail.com',
            'profile'=>'Admin',
            'status'=>'Active',
            'password'=>bcrypt('12341234')
        ]);
        $adminUser->assignRole($adminRole);
        $employeeUser = User::create([
            'name'=>'Invitado',
            'phone'=>'1029534344',
            'email'=>'invitado@gmail.com',
            'profile'=>'Employee',
            'status'=>'Active',
            'password'=>bcrypt('12341234')
        ]);
        $employeeUser->assignRole($employeeRole);
    }
}
