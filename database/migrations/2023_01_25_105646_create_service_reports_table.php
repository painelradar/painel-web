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
        Schema::create('service_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('time');
            $table->unsignedBigInteger('number_id')->unsigned();
            $table->foreign('number_id')->references('id')->on('numbers');
            $table->unsignedBigInteger('attendant_id')->unsigned();
            $table->foreign('attendant_id')->references('id')->on('attendants');
            $table->unsignedBigInteger('queue_id')->unsigned();
            $table->foreign('queue_id')->references('id')->on('queues');
            $table->enum('action', ['CALL', 'REPEAT', 'CONCLUDE', 'ABSENT', 'ROUTE']);
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
        Schema::dropIfExists('service_reports');
    }
};
