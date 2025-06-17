<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('shipping_infos', function(Blueprint $table){
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->enum('method', ['ambil_di_tempat', 'antar']);
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('phone');
            $table->text('notes')->nullable();
            $table->enum('status_barang',['selesai','belum selesai'])->default('belum selesai');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shipping_infos');
    }
};