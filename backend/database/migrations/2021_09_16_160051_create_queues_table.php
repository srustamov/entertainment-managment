<?php

use App\Models\Queue;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('location_id')->index();
            $table->unsignedInteger('activity_id')->index();
            $table->integer('number');
            $table->tinyInteger('type');
            $table->timestamp(Queue::STARTED_AT)->nullable();
            $table->timestamp(Queue::END_AT)->nullable();
            $table->timestamp(Queue::MISSING_AT)->nullable();
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
        Schema::dropIfExists('queues');
    }
}
