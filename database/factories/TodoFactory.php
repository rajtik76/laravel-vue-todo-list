<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TodoFactory extends Factory
{
    protected $model = Todo::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'note' => $this->faker->word(),
            'finished' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
        ];
    }

    public function finished(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'finished' => true,
        ]);
    }

    public function notFinished(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'finished' => false,
        ]);
    }
}
