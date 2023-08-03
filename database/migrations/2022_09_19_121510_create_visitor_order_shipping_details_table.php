<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitor_order_shipping_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipping_companies_id')->constrained()->onDelete('cascade');
            $table->foreignId('vistor_orders_id')->constrained()->onDelete('cascade');
            $table->string('tracking_url');
            $table->integer('days');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitor_order_shipping_details');
    }
};
