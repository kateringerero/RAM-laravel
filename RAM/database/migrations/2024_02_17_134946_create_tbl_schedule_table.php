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
        if (!Schema::hasTable('tbl_schedule')) {
            Schema::create('tbl_schedule', function (Blueprint $table) {
                $table->id();
                $table->string('creator_id');
                $table->string('reference_id')->unique();
                $table->date('scheduled_date');
                $table->time('start_time');
                $table->time('end_time');
                $table->string('purpose');
                $table->enum('status', ['pending', 'confirmed', 'cancelled']);
                $table->string('handled_by')->nullable();
                $table->timestamps();
            });
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_schedule');
    }
};
