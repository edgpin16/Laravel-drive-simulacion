<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = File::class;

    public function definition()
    {
        return [
            //
            'id_user' => User::all()->random()->id,
            'id_file_drive' => fake()->unique()->regexify('[A-Za-z0-9]{20}'),
        ];
    }
}
