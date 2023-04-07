<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTotalRestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('total_rests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_id')->references('id')->on('attendances');
            $table->foreignId('rest_id')->references('id')->on('rests')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->time('total_rest');
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
        Schema::dropIfExists('total_rests');
    }
}
