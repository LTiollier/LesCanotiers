<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var User $user */
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com'
        ]);

        $admin->assignRole('admin');

        /** @var User $user */
        $employee = User::factory()->create([
            'name' => 'Employee User',
            'email' => 'employee@gmail.com'
        ]);

        $employee->assignRole('employee');
    }
}
