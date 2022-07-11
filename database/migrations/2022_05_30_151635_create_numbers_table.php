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
        Schema::create('numbers', function (Blueprint $table) {
            $table->id();
            $table->integer('integerNumber');
            $table->string('stringNumber');
            $table->string('pa');
            $table->string('coop');
            $table->enum('status', ['WAITING', 'IN_SERVICE', 'FINISHED', 'ABSENT']);
            $table->unsignedBigInteger('queue_id');
            $table->foreign('queue_id')->references('id')->on('queues');
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
        Schema::dropIfExists('numbers');
    }
};
