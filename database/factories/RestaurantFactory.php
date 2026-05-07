<?php

namespace Database\Factories;

use App\Models\Restaurant;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class RestaurantFactory extends Factory
{
    /**
     * The name of the factory"s corresponding model.
     *
     * @var string
     */
    protected $model = Restaurant::class;

    /**
     * Define the model"s default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name(),
            "address" => $this->faker->address(),
            "phone" => $this->faker->phoneNumber(),
            "logo" => $this->faker->name(),
            "email" => $this->faker->email(),
            "img" => $this->faker->name(),
            "minimum_purchase" => rand(0, 9),
            "hidden" => rand(0, 1),
            "delivery_time" => rand(10, 60),
            "shipping_amount" => rand(0, 9),
            "benefit_ticket" => rand(10, 30),
            "quota" => rand(10, 100),
            "status" => Str::random(8),
            "slug" => Str::random(10),
            "minimal_slug" => Str::random(4),
            "user" => $this->faker->name(),
            "pass" => Str::random(10),
            "token" => Str::random(50),
            "delivery" => rand(0, 1),
            "take_away" => rand(0, 1),
            "manage_menu" => rand(0, 1),
            "manage_orders" => rand(0, 1),
            "report" => rand(0, 1),
            "manage_tablet" => rand(0, 1)
        ];
    }
}
