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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("product_id");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("product_id")->references("id")->on("products")->onupdate("cascade");
            $table->string("Status");
            $table->string("Value_Status");
            $table->string("Payment_status");
            $table->string("Phone");
            $table->string("Address");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
