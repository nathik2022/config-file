<?php

namespace Database\Factories;

use App\Models\ConfigFile;
use Illuminate\Database\Eloquent\Factories\Factory;


class ConfigFileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ConfigFile::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(6),
            'created_at' => $this->faker->dateTimeBetween('-3 months'),
        ];
    }

    public function newTitle()
    {
        return $this->state([
            'title' => 'New File',
        ]);
    }
}
