<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IceCreamPosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Payment Methods
        DB::table('payment_methods')->insert([
            [
                'name' => 'Cash',
                'code' => 'cash',
                'is_active' => true,
                'description' => 'Pembayaran tunai',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Debit Card',
                'code' => 'card',
                'is_active' => true,
                'description' => 'Pembayaran dengan kartu debit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'QRIS',
                'code' => 'qris',
                'is_active' => true,
                'description' => 'Pembayaran dengan QRIS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'OVO',
                'code' => 'ovo',
                'is_active' => true,
                'description' => 'Pembayaran dengan OVO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'GoPay',
                'code' => 'gopay',
                'is_active' => true,
                'description' => 'Pembayaran dengan GoPay',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed Products - Ice Cream
        DB::table('products')->insert([
            [
                'name' => 'Vanilla Ice Cream',
                'description' => 'Es krim vanilla klasik',
                'price' => 15000,
                'category' => 'ice_cream',
                'is_active' => true,
                'stock_quantity' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chocolate Ice Cream',
                'description' => 'Es krim coklat premium',
                'price' => 18000,
                'category' => 'ice_cream',
                'is_active' => true,
                'stock_quantity' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Strawberry Ice Cream',
                'description' => 'Es krim strawberry segar',
                'price' => 17000,
                'category' => 'ice_cream',
                'is_active' => true,
                'stock_quantity' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed Products - Toppings
        DB::table('products')->insert([
            [
                'name' => 'Chocolate Chips',
                'description' => 'Topping chocolate chips',
                'price' => 3000,
                'category' => 'topping',
                'is_active' => true,
                'stock_quantity' => 200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sprinkles',
                'description' => 'Topping sprinkles warna-warni',
                'price' => 2000,
                'category' => 'topping',
                'is_active' => true,
                'stock_quantity' => 200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nuts',
                'description' => 'Topping kacang-kacangan',
                'price' => 4000,
                'category' => 'topping',
                'is_active' => true,
                'stock_quantity' => 150,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed Products - Cups and Cones
        DB::table('products')->insert([
            [
                'name' => 'Regular Cup',
                'description' => 'Cup biasa untuk es krim',
                'price' => 0,
                'category' => 'cup',
                'is_active' => true,
                'stock_quantity' => 500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Waffle Cone',
                'description' => 'Cone waffle premium',
                'price' => 5000,
                'category' => 'cone',
                'is_active' => true,
                'stock_quantity' => 200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sugar Cone',
                'description' => 'Cone gula klasik',
                'price' => 3000,
                'category' => 'cone',
                'is_active' => true,
                'stock_quantity' => 300,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed Discounts
        DB::table('discounts')->insert([
            [
                'name' => 'Happy Hour',
                'code' => 'HAPPY10',
                'type' => 'percentage',
                'value' => 10,
                'minimum_purchase' => 25000,
                'start_date' => now()->format('Y-m-d'),
                'end_date' => now()->addMonths(3)->format('Y-m-d'),
                'is_active' => true,
                'description' => 'Diskon 10% untuk pembelian minimal 25rb',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Buy 2 Get 1',
                'code' => 'BUY2GET1',
                'type' => 'fixed_amount',
                'value' => 15000,
                'minimum_purchase' => 45000,
                'start_date' => now()->format('Y-m-d'),
                'end_date' => now()->addMonths(1)->format('Y-m-d'),
                'is_active' => true,
                'description' => 'Potongan 15rb untuk pembelian minimal 45rb',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
