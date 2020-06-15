<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('sku');	
            $table->string('name');	
            $table->longText('description');
            $table->json('image');
            $table->string('status')->default('draft');
            $table->mediumInteger('ownerid');
            $table->mediumInteger('storeid')->default('0');
            $table->string('pricing');	
            $table->timestamps();
        });
    }
    // ID - [int] product id
    // SKU - [string] stock keeping unit
    // name - [string] name of the product
    // description = [string] description of the product
    // image - [json] group of images
    // status - [string] draft, published, disabled
    // ownerID - [int] user id of the owner
    // storeID - [int] store on which the product is listed.
    //           0 if it does not belong to any store/market
    // created - [string] timestamp of creation
    // updated - [string] updated timestamp
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
