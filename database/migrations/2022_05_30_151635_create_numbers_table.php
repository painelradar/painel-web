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
            $table->softDeletes();
            $table->integer('integerNumber');
            $table->string('stringNumber');
            $table->enum('status', ['WAITING', 'IN_SERVICE', 'FINISHED', 'ABSENT']);
            $table->unsignedBigInteger('queue_id');
            $table->foreign('queue_id')->references('id')->on('queues');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
