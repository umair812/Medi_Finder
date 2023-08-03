<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Null_;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->nullable()->default(Null);
            $table->string('title');
            $table->string('content');
            $table->text('description');
            $table->float('price');
            $table->float('sale_price');
            $table->float('sale_in_percentage');
            $table->integer('quantity');
            $table->bigInteger('order');
            $table->string('main_media');
            $table->text('suppornting_media');
            $table->unsignedBigInteger('brand_id');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->unsignedBigInteger('cat_id');
            $table->foreign('cat_id')->references('id')->on('categories');
            $table->unsignedBigInteger('sub_cat_id');
            $table->foreign('sub_cat_id')->references('id')->on('sub_categories');
            $table->text('tags');
            $table->string('badges');
            $table->enum('stock_availability',['In Stock','Out Of Stock']);
            $table->enum('allow_checkout',['Yes','No']);
            $table->enum('is_feature',['Featured','Not Featured']);
            $table->enum('new_added',['Yes','No']);
            $table->enum('is_publish',['Publish','Draft']);
            $table->enum('status',['Active','Deleted']);
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
        Schema::dropIfExists('products');
    }
};
