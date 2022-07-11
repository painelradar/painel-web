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
        Schema::create('queue_to_calls', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('stringNumber');
            $table->string('queue');
            $table->integer('queue_id');
            $table->string('table_number');
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
        Schema::dropIfExists('queue_to_calls');
    }
};
