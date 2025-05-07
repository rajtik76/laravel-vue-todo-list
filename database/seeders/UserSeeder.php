<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'name' => 'First User',
            'email' => 'first@example.com',
        ]);

        User::factory()->create([
            'name' => 'Second User',
            'email' => 'second@example.com',
        ]);
    }
}
