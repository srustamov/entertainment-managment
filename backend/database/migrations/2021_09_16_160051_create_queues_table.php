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
            $table->morphs('queueable', true);
            $table->integer('number');
            $table->integer('status_id')->default(1);
            $table->timestamp(Queue::STARTED_AT)->nullable();
            $table->timestamp(Queue::END_AT)->nullable();
            $table->timestamp(Queue::MISSING_AT)->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
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
