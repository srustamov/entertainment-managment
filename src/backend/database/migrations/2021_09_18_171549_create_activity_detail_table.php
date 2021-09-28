<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_detail', function (Blueprint $table) {
            $table->id();
            $table->morphs('activitable',true);
            $table->string('color')->nullable();
            $table->string('number')->nullable();
            $table->string('size')->nullable();
            $table->double('period_price',8,2);
            $table->double('period',8,2)->comment('dəqiqə ilə');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_detail');
    }
}
