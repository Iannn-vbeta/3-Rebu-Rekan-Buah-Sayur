<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingInfo;
use App\Models\Payment;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        // Roles
        $adminRole = Role::create(['role' => 'admin']);
        $buyerRole = Role::create(['role' => 'pembeli']);

        // Users
        $admin = User::create([
            'id_role' => $adminRole->id_role,
            'username' => 'Admin',
            'email' => 'admin@lykos.com',
            'email_verified_at' => $now,
            'password' => Hash::make('password123'),
            'remember_token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $buyer = User::create([
            'id_role' => $buyerRole->id_role,
            'username' => 'User',
            'email' => 'user@lykos.com',
            'email_verified_at' => $now,
            'password' => Hash::make('password123'),
            'remember_token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Products
        $product1 = Product::create([
            'name' => 'Kaos Anime',
            'description' => 'Kaos dengan desain anime keren',
            'price' => 120000,
            'stock' => 100,
            'image' => 'kaos_anime.jpg',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $product2 = Product::create([
            'name' => 'Gantungan Kunci Game',
            'description' => 'Gantungan kunci dengan tema video game',
            'price' => 45000,
            'stock' => 200,
            'image' => 'gantungan_kunci.jpg',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Cart
        $cart = Cart::create([
            'user_id' => $buyer->id,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product1->id,
            'quantity' => 2,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product2->id,
            'quantity' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Order
        $totalPrice = 120000 * 2 + 45000;

        $order = Order::create([
            'user_id' => $buyer->id,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product1->id,
            'quantity' => 2,
            'price' => 120000,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product2->id,
            'quantity' => 1,
            'price' => 45000,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Shipping Info
        ShippingInfo::create([
            'order_id' => $order->id,
            'method' => 'antar',
            'address' => 'Jl. Merpati No. 45',
            'city' => 'Jakarta',
            'phone' => '08123456789',
            'notes' => 'Tolong dikemas dengan rapi',
            'status_barang' => 'belum selesai',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Payment
        Payment::create([
            'order_id' => $order->id,
            'payment_gateway' => 'midtrans',
            'payment_status' => 'pending',
            'transaction_id' => null,
            'amount' => $totalPrice,
            'paid_at' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}