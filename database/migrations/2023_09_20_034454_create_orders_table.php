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
            $table->string('name');
            $table->text('company_name')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->string('postcode', 6);
            $table->string('mobile', 11);
            $table->string('email');
            $table->text('order_notes')->nullable();
            $table->integer('status')->default(1)->comment('0 = failed, 1 = processing');
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
