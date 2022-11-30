<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LaratrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a user
        $user = User::factory()->create([
            'name'     => $name = 'Test User',
            'email'    => 'test@gmail.com',
            'password' => Hash::make('test123'),
        ]);

        $user->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', 'test-token-for-test-user'),
            'abilities' => ['*'],
        ]);
    }
}
