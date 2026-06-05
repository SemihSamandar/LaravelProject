<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shopping_carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('session_id')->nullable(); // Eğer user login değilse session
            $table->unsignedBigInteger('user_id')->nullable(); // Eğer login ise user
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2); // Satın alınırken ürünün fiyatı
            $table->timestamps();
            
            // Foreign keys
           
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Index
            $table->index('session_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shopping_carts');
    }
};
