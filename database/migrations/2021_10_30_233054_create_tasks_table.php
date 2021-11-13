<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('round_id');
            $table->string('title');
            $table->string('description');
            $table->enum('difficulty', ['instant','auto_delayed','easy','normal','hard','extreme','other']);
            $table->string('link')->nullable();
            $table->unsignedSmallInteger('tickets')->default(1);
            $table->boolean('input_required')->default(false);
            $table->boolean('primary')->default(false);
            $table->string('input_title')->nullable();
            $table->timestamps();

            $table->foreign('round_id')->references('id')->on('rounds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
