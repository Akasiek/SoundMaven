<?php

namespace Database\Seeders;

use App\Enums\UserRoles;
use App\Models\User;
use Exception;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedAdmin();
    }

    private function seedAdmin(): void
    {
        if (User::where('name', 'admin')->exists()) {
            return;
        }

        $email = config('app.admin.email');
        $password = config('app.admin.password');

        if (empty($email) || empty($password)) {
            throw new Exception('Admin credentials not set in .env file or application is cached');
        }

        User::factory()->createOne([
            'name' => 'admin',
            'email' => $email,
            'password' => bcrypt($password),
            'role' => UserRoles::ADMIN,
        ]);
    }
}
