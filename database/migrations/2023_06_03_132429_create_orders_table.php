<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        // Create orders table
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_value');
            $table->unsignedBigInteger('user_id');
            $table->date('date');

            // Define foreign key constraint
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        // Drop orders table
        Schema::dropIfExists('orders');
    }
}
