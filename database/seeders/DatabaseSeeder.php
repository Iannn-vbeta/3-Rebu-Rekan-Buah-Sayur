<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingInfo;
use App\Models\Payment;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Roles
        $adminRole = Role::create(['role' => 'admin']);
        $buyerRole = Role::create(['role' => 'pembeli']);

        // Users
        $admin = User::create([
            'id_role' => $adminRole->id_role,
            'username' => 'Admin',
            'email' => 'admin@lykos.com',
            'password' => Hash::make('password123'),
        ]);

        $buyer = User::create([
            'id_role' => $buyerRole->id_role,
            'username' => 'User',
            'email' => 'user@lykos.com',
            'password' => Hash::make('password123'),
        ]);

        // Products
        $product1 = Product::create([
            'name' => 'Kaos Anime',
            'description' => 'Kaos dengan desain anime keren',
            'price' => 120000,
            'stock' => 100,
            'image' => 'kaos_anime.jpg',
        ]);
        $product2 = Product::create([
            'name' => 'Gantungan Kunci Game',
            'description' => 'Gantungan kunci dengan tema video game',
            'price' => 45000,
            'stock' => 200,
            'image' => 'gantungan_kunci.jpg',
        ]);

        // Cart for buyer
        $cart = Cart::create(['user_id' => $buyer->id]);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product1->id,
            'quantity' => 2,
        ]);
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product2->id,
            'quantity' => 1,
        ]);

        // Order
        $order = Order::create([
            'user_id' => $buyer->id,
            'total_price' => 120000*2 + 45000*1,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Order Items
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product1->id,
            'quantity' => 2,
            'price' => 120000,
        ]);
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product2->id,
            'quantity' => 1,
            'price' => 45000,
        ]);

        // Shipping Info
        ShippingInfo::create([
            'order_id' => $order->id,
            'method' => 'antar',
            'address' => 'Jl. Merpati No. 45',
            'city' => 'Jakarta',
            'phone' => '08123456789',
            'notes' => 'Tolong dikemas dengan rapi',
        ]);

        // Payment
        Payment::create([
            'order_id' => $order->id,
            'payment_gateway' => 'midtrans',
            'payment_status' => 'pending',
            'transaction_id' => null,
            'amount' => 120000*2 + 45000*1,
            'paid_at' => null,
        ]);
    }
}