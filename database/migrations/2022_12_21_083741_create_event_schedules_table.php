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
        Schema::create('event_schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('events_id');
            $table->string('title');
            $table->date('schedule_date');
            $table->time('schedule_time');
            $table->text('description');
            $table->enum('status', ['active', 'deactive'])->default('active');
            $table->timestamps();
            $table->userlog();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_schedules');
    }
};
