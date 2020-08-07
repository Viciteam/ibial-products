<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('connections', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('user_id');
        //     $table->string('business_id');
        //     $table->string('name');
        //     $table->string('name');
        //     $table->string('name');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('connections');
    }
}
