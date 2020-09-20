<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_schedule', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_reference'); // merchant 
            $table->string('next_payment'); // transaction id
            $table->string('scheme'); // monthly, annual, quarterly, one-time
            $table->string('price'); // price 
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
        Schema::dropIfExists('billing_schedule');
    }
}
