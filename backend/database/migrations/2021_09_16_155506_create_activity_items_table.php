<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('activity_id')->index();
            $table->string('name');
            $table->string('color')->nullable();
            $table->string('number')->nullable();
            $table->string('size')->nullable();
            $table->double('period_price',8,2);
            $table->double('period',8,2)->comment('dəqiqə ilə');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_items');
    }
}
