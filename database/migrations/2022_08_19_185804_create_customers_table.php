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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->string('email_addr', 50)->unique();
            $table->enum('gender',['Male','Female','Other']);
            $table->string('password', 30);
            $table->string('contact_number', 30)->nullable();
            $table->date('dob')->nullable();
            $table->string('address1', 50)->nullable();
            $table->string('address2', 50)->nullable();
            $table->string('city', 20)->nullable();
            $table->string('state', 20)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->integer('loyality_points')->default(0);
            $table->enum('status',['Active','Pending','Suspended','Deleted'])->default('Pending');
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
        Schema::dropIfExists('customers');
    }
};
