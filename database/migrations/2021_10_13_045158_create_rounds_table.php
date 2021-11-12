<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Round;

class CreateRoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rounds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('block_number');
            $table->unsignedInteger('estimated_block_time');
            $table->unsignedInteger('rewards');
            $table->text('description')->nullable();
            $table->boolean('active')->default(false);
            $table->boolean('completed')->default(false);
            $table->string('resulting_hash')->nullable();
            $table->unsignedInteger('results_total_winners_count')->nullable();
            $table->timestamps();
        });

        // Create first round if db is empty
        Round::firstOrCreate(
            ['id' =>  1],
            [
                'block_number' => 0,
                'active'       => true,
                'rewards'      => 15000,
                'estimated_block_time' => time() + 606000
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rounds');
    }
}
