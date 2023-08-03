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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customers_id')->constrained()->onDelete('cascade');
            $table->enum('is_same_as_billing',[1,0])->default(1);
            $table->text('note')->nullable();
            $table->float('bill')->default(0.0);
            $table->integer('item')->default(0);
            $table->enum('payment_method',['Cash On Delivery','Paypal'])->default('Cash On Delivery');
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
        Schema::dropIfExists('orders');
    }
};
