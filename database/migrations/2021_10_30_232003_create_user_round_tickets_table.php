<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRoundTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_round_tickets', function (Blueprint $table) {
            $ticket_length = config('custom.tickets.length', 64);
            $ticket_types_enum = config('custom.tickets.type_enums', ['signup','referral','task','other']);

            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('round_id');
            $table->char('ticket', $ticket_length);
            $table->enum('type', $ticket_types_enum)->nullable();
            $table->unsignedBigInteger('related_id')->default(0);
            $table->boolean('won')->nullable();
            $table->decimal('won_amount', 8,2)->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('user_round_tickets');
    }
}
