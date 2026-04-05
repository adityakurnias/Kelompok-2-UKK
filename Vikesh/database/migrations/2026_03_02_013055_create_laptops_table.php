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
    Schema::create('laptops', function (Blueprint $table) {
        $table->id();
        $table->string('model');       // e.g., ThinkPad T480
        $table->string('processor');   // e.g., Intel Core i5-8350U
        $table->string('ram');         // e.g., 16GB
        $table->string('storage');     // e.g., 256GB NVMe SSD
        $table->unsignedBigInteger('price'); // Using BigInt for Rupiah amounts
        $table->text('description');
        $table->string('image')->nullable(); // Stores the file path
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laptops');
    }
};
