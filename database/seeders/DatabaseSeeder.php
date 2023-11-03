<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\OptionFactory;
use Database\Factories\OptionValueFactory;
use Database\Factories\PropertyFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::factory()->create([
            'name' => 'Камиль',
            'email' => 'kamil@mail.ru',
            'password' => bcrypt(12345678)
        ]);

        BrandFactory::new()->count(20)->create();

        $properties = PropertyFactory::new()->count(10)->create();

        OptionFactory::new()->count(2)->create();

        $optionValue = OptionValueFactory::new()->count(10)->create();

        CategoryFactory::new()->count(10)
            ->has(Product::factory(10)
                ->hasAttached($optionValue)
                ->hasAttached($properties, function (){
                    return ['value' => ucfirst(fake()->word())];
                })
            )
            ->create();


    }
}
