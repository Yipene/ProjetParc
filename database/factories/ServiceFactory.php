<?php

namespace Database\Factories;
use App\Models\Service\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{

    protected $model = Service::class;

    public function definition()
    {
        return [
            'nom_service' => $this->faker->word(),
        ];
    }
}
