<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRoundStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_round_stats', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('round_id');
            $table->unsignedBigInteger('tickets')->default(0);
            $table->unsignedBigInteger('referrals')->default(0);
            $table->boolean('won')->nullable();
            $table->decimal('won_amount', 8,2)->default(0);
            $table->string('details')->nullable();
            $table->timestamps();

            $table->primary(['user_id','round_id']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('user_round_stats');
    }
}
