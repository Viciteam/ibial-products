<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_order', function (Blueprint $table) {
            $table->id();
            $table->string('package_id');	
            $table->string('extra_name');	
            $table->longText('extra_description');
            $table->string('price');	
            $table->string('subscription');	
            $table->string('frequency');	
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
        Schema::dropIfExists('extra_order');
    }
}
