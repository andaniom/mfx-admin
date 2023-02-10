<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('task_id');
            $table->string('old_status')->nullable();
            $table->string('new_status')->nullable();
            $table->unsignedInteger('updated_by');
            $table->timestamps();

//            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_histories');
    }
}
