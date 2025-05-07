<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Seed 3 todos per user
     */
    public function run(): void
    {
        foreach (User::all() as $user) {
            Todo::factory()
                ->count(3)
                ->for($user)
                ->notFinished()
                ->create();
        }
    }
}
