<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->seedCategories();
        $this->seedProducts();
    }

    private function seedCategories(): void
    {
        $categories = [
            [
                'name' => 'Makeup 666',
                'slug' => 'makeup-666',
                'description' => 'Premium cosmetics and makeup products for all your beauty needs.',
                'image_url' => '/images/categories/makeup.jpg'
            ],
            [
                'name' => 'Nazleh Jewellery',
                'slug' => 'nazleh-jewellery',
                'description' => 'Exquisite jewelry pieces crafted with precision and elegance.',
                'image_url' => '/images/categories/jewelry.jpg'
            ],
            [
                'name' => 'Nazleh Ounce',
                'slug' => 'nazleh-ounce',
                'description' => 'Premium gold ounces in various weights for investment and collection.',
                'image_url' => '/images/categories/gold.jpg'
            ],
            [
                'name' => 'Nazleh Clothes',
                'slug' => 'nazleh-clothes',
                'description' => 'Fashionable clothing designed and produced with quality materials.',
                'image_url' => '/images/categories/clothes.jpg'
            ],
            [
                'name' => 'The Kanz',
                'slug' => 'the-kanz',
                'description' => 'Luxurious perfumes and fragrances for every occasion.',
                'image_url' => '/images/categories/perfumes.jpg'
            ]
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(['slug' => $categoryData['slug']], $categoryData);
        }
    }

    private function seedProducts(): void
    {
        $makeup = Category::where('slug', 'makeup-666')->first();
        $jewelry = Category::where('slug', 'nazleh-jewellery')->first();
        $gold = Category::where('slug', 'nazleh-ounce')->first();
        $clothes = Category::where('slug', 'nazleh-clothes')->first();
        $perfume = Category::where('slug', 'the-kanz')->first();

        $products = [
            // Makeup products
            [
                'name' => 'Premium Foundation',
                'slug' => 'premium-foundation',
                'description' => 'Long-lasting foundation with full coverage and natural finish.',
                'price' => 45.99,
                'category_id' => $makeup->id,
                'stock_quantity' => 50,
                'image_url' => '/images/products/foundation.jpg'
            ],
            [
                'name' => 'Luxury Lipstick Set',
                'slug' => 'luxury-lipstick-set',
                'description' => 'Set of 5 premium lipsticks in trending colors.',
                'price' => 89.99,
                'category_id' => $makeup->id,
                'stock_quantity' => 30,
                'image_url' => '/images/products/lipstick-set.jpg'
            ],
            
            // Jewelry products
            [
                'name' => 'Diamond Engagement Ring',
                'slug' => 'diamond-engagement-ring',
                'description' => 'Stunning 1-carat diamond ring in 18k white gold setting.',
                'price' => 2999.99,
                'category_id' => $jewelry->id,
                'stock_quantity' => 5,
                'image_url' => '/images/products/diamond-ring.jpg'
            ],
            [
                'name' => 'Gold Necklace',
                'slug' => 'gold-necklace',
                'description' => 'Elegant 18k gold necklace with intricate design.',
                'price' => 899.99,
                'category_id' => $jewelry->id,
                'stock_quantity' => 15,
                'image_url' => '/images/products/gold-necklace.jpg'
            ],
            
            // Gold products
            [
                'name' => '1 Ounce Gold Bar',
                'slug' => '1-ounce-gold-bar',
                'description' => 'Pure 24k gold bar, 1 ounce weight, certified authentic.',
                'price' => 1950.00,
                'category_id' => $gold->id,
                'stock_quantity' => 20,
                'weight' => '1 oz',
                'image_url' => '/images/products/1oz-gold.jpg'
            ],
            [
                'name' => '5 Ounce Gold Bar',
                'slug' => '5-ounce-gold-bar',
                'description' => 'Pure 24k gold bar, 5 ounce weight, certified authentic.',
                'price' => 9750.00,
                'category_id' => $gold->id,
                'stock_quantity' => 10,
                'weight' => '5 oz',
                'image_url' => '/images/products/5oz-gold.jpg'
            ],
            
            // Clothes products
            [
                'name' => 'Designer Dress',
                'slug' => 'designer-dress',
                'description' => 'Elegant evening dress made from premium silk fabric.',
                'price' => 299.99,
                'category_id' => $clothes->id,
                'stock_quantity' => 25,
                'image_url' => '/images/products/designer-dress.jpg'
            ],
            [
                'name' => 'Casual Shirt',
                'slug' => 'casual-shirt',
                'description' => 'Comfortable cotton shirt perfect for everyday wear.',
                'price' => 79.99,
                'category_id' => $clothes->id,
                'stock_quantity' => 40,
                'image_url' => '/images/products/casual-shirt.jpg'
            ],
            
            // Perfume products
            [
                'name' => 'Luxury Perfume - Royal',
                'slug' => 'luxury-perfume-royal',
                'description' => 'Exquisite fragrance with notes of rose, vanilla, and musk.',
                'price' => 149.99,
                'category_id' => $perfume->id,
                'stock_quantity' => 35,
                'image_url' => '/images/products/perfume-royal.jpg'
            ],
            [
                'name' => 'Fresh Cologne',
                'slug' => 'fresh-cologne',
                'description' => 'Light and refreshing cologne perfect for daily use.',
                'price' => 69.99,
                'category_id' => $perfume->id,
                'stock_quantity' => 50,
                'image_url' => '/images/products/fresh-cologne.jpg'
            ]
        ];

        foreach ($products as $productData) {
            Product::firstOrCreate(['slug' => $productData['slug']], $productData);
        }
    }
}
