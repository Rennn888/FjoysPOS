<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FjoysMenuSeeder extends Seeder
{
    public function run()
    {
        // Clear existing products
        $this->db->table('products')->truncate();
        
        $data = [
            // RICE MEALS
            [
                'name' => 'Wing Meal (2 pcs + Rice)',
                'price' => 79.00,
                'category' => 'Rice Meals',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Double Wing Meal (4 pcs + Rice)',
                'price' => 129.00,
                'category' => 'Rice Meals',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            
            // ALA CARTE WINGS
            [
                'name' => 'Wingmates (6 pcs)',
                'price' => 159.00,
                'category' => 'Ala Carte Wings',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Triple Feast (12 pcs)',
                'price' => 299.00,
                'category' => 'Ala Carte Wings',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Wing Fiesta (18 pcs)',
                'price' => 419.00,
                'category' => 'Ala Carte Wings',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            
            // OTHER FAVORITES
            [
                'name' => 'Hungarian Sausage w/ rice',
                'price' => 59.00,
                'category' => 'Other Favorites',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Crispy Fries - S',
                'price' => 35.00,
                'category' => 'Other Favorites',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Crispy Fries - M',
                'price' => 55.00,
                'category' => 'Other Favorites',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Crispy Fries - L',
                'price' => 75.00,
                'category' => 'Other Favorites',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Chicky Bites - 6pcs',
                'price' => 69.00,
                'category' => 'Other Favorites',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Chicky Bites - 12pcs',
                'price' => 119.00,
                'category' => 'Other Favorites',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            
            // SANDWICHES
            [
                'name' => 'Chicken Burger',
                'price' => 0.00, // Price to be determined
                'category' => 'Sandwiches',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Hungarian Sausage in a Bun',
                'price' => 69.00, // Price to be determined
                'category' => 'Sandwiches',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            
            // DRINKS
            [
                'name' => 'Blue Lemonade - 16oz',
                'price' => 20.00,
                'category' => 'Drinks',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Blue Lemonade - 22oz',
                'price' => 30.00,
                'category' => 'Drinks',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Cucumber Juice - 16oz',
                'price' => 20.00,
                'category' => 'Drinks',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Cucumber Juice - 22oz',
                'price' => 30.00,
                'category' => 'Drinks',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            
            // DIPS
            [
                'name' => 'Garlic Mayo',
                'price' => 20.00,
                'category' => 'Dips',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Cheese Dip',
                'price' => 20.00,
                'category' => 'Dips',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('products')->insertBatch($data);
        
        echo "Fjoy's Menu loaded successfully! Total items: " . count($data) . "\n";
    }
}
