<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('business_inventory_metric_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("business_id");
            $table->unsignedBigInteger("inventory_id");
            $table->unsignedBigInteger("metrics_id");
            $table->double("price");
            $table->timestamps();

            $table->foreign("business_id")->references("id")->on("business");
            $table->foreign("inventory_id")->references("id")->on("inventory");
            $table->foreign("metrics_id")->references("id")->on("metrics");
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('business_inventory_metric_prices');
    }
};
