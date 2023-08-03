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
        Schema::create('vistor_orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mac_add')->unique();
            $table->bigInteger('ip')->nullable();
            $table->text('note')->nullable();
            $table->float('bill')->default(0.0);
            $table->integer('item')->default(0);
            $table->enum('payment_method',['Cash On Delivery','Paypal'])->default('Cash On Delivery');
            $table->string('first_name', 30)->nullable();
            $table->string('last_name', 30)->nullable();
            $table->string('contact_number', 30)->nullable();
            $table->string('address1', 50)->nullable();
            $table->string('address2', 50)->nullable();
            $table->string('city', 20)->nullable();
            $table->string('state', 20)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->enum('status',['Pending','Accepted','Dispatched','Completed'])->default('Pending');
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
        Schema::dropIfExists('vistor_orders');
    }
};
