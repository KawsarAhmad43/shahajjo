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
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug');
            $table->date('notice_date');
            $table->date('notice_end')->nullable();
            $table->string('type');
            $table->string('file')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('notices');
    }
};
