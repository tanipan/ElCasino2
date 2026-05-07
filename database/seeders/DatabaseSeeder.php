<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\User;
use App\Models\Address;
use App\Models\Customer;
use App\Models\DishType;
use App\Models\Restaurant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(1)->create([
            'name' => 'Carlos',
            'email' => 'tanipan@gmail.com',
            'password' => Hash::make('wape16kari'),
            'role' => 'admin',
        ]);

        $customers = Customer::factory(50)->create();
        foreach ($customers as $customer) {
            Address::factory(rand(1, 4))->create(
                [
                    'customer_id' => $customer->id
                ]
            );
        }

        //$restaurants = Restaurant::factory(5)->create();

        $restaurant = Restaurant::factory()->count(1)->create([
            'name' => 'Los Bartolos',
            'email' => 'info@losbartolos.com',
            'address' => 'C. Alfonso X el Sabio, 1, 30840 Alhama de Murcia, Murcia',
        ]);


        $dishes = DishType::factory(50)->create();


        foreach ($dishes as $dish) {
            Dish::factory(rand(1, 15))->create([
                'restaurant_id' => $restaurant[0]->id,
                'dish_type_id' => $dish->id,
            ]);
        }
    }
}
