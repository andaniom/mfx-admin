<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('date')->nullable();
            $table->time('check_in')->nullable();
            $table->boolean('is_check_in')->default(false);
            $table->time('check_out')->nullable();
            $table->boolean('is_check_out')->default(false);
            $table->boolean('is_late')->default(false);
            $table->boolean('is_early_out')->default(false);
            $table->integer('late_time')->nullable();
            $table->integer('early_out_time')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
