<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menu_items')->insert([
            [
                'name' => 'Baked Fish with Vegetables',
                'description' => 'Tender baked fish',
                'price' => 12.99,
                'category' => 'main'
            ],
            [
                'name' => 'Beef Stew with Vegetables',
                'description' => 'Hearty beef stew',
                'price' => 10.13,
                'category' => 'main'
            ],
            [
                'name' => 'Burger with a side of Fries and a Salaad',
                'description' => 'Classic combo',
                'price' => 17.47,
                'category' => 'main'
            ],
            [
                'name' => 'Chicken Breast with Mashed Potatoes',
                'description' => 'Juicy chicken meal',
                'price' => 9.83,
                'category' => 'main'
            ],
            [
                'name' => 'Crispy Fried Chicken Platter',
                'description' => 'Crunchy chicken plate',
                'price' => 12.99,
                'category' => 'main'
            ],
            [
                'name' => 'Fried Chicken Combo',
                'description' => 'Chicken with sides',
                'price' => 13.52,
                'category' => 'main'
            ],
            [
                'name' => 'Fried Chicken with Mashed Potatoes and Vegetables',
                'description' => 'Full chicken meal',
                'price' => 18.55,
                'category' => 'main'
            ],
            [
                'name' => 'Fried Chicken',
                'description' => 'Classic fried chicken',
                'price' => 8.39,
                'category' => 'main'
            ], 
            [
                'name' => "General TSO'S Chicken",
                'description' => 'Sweet spicy chicken',
                'price' => 14.25,
                'category' => 'main'
            ],
            [
                'name' => 'Gourment Burger',
                'description' => 'Premium beef burger',
                'price' => 11.67,
                'category' => 'main'
            ], 
            [
                'name' => 'Grilled Fish Fillet with Sauteed Peppers and Herb Garnish',
                'description' => 'Fresh grilled fish',
                'price' => 13.66,
                'category' => 'main'
            ],
            [
                'name' => 'Grilled Fish with Vegetables',
                'description' => 'Light fish meal',
                'price' => 7.48,
                'category' => 'main'
            ],
            [
                'name' => 'Grilled Salmon with Vegetables',
                'description' => 'Salmon with sides',
                'price' => 10.32,
                'category' => 'main'
            ],
            [
                'name' => 'Herb-Crushed Chicken with Sauteed Greens and Bacon Crumble',
                'description' => 'Herb chicken mix',
                'price' => 15.24,
                'category' => 'main'
            ],
            [
                'name' => 'Pan-Seared Fish Fillet with Peppers and Herbs',
                'description' => 'Crispy fish fillet',
                'price' => 13.27,
                'category' => 'main'
            ],
            [
                'name' => 'Pan-Seared Fish with Vegetables',
                'description' => 'Fish and Veggie',
                'price' => 8.71,
                'category' => 'main'
            ],
            [
                'name' => 'Roasted Chicken',
                'description' => 'Oven-roated chicken',
                'price' => 6.99,
                'category' => 'main'
            ],
            [
                'name' => 'Spaghetti Bolognese',
                'description' => 'Beefy pasta dish',
                'price' => 14.59,
                'category' => 'pasta'
            ],
            [
                'name' => 'Spaghetti Marinara',
                'description' => 'Tomato-based pasta',
                'price' => 9.83,
                'category' => 'pasta'
            ],
            [
                'name' => 'Spicy Crispy Bites with Stir-Fried Vegetables',
                'description' => 'Spicy fried chicken',
                'price' => 12.46,
                'category' => 'main'
            ]
        ]);
    }
}
