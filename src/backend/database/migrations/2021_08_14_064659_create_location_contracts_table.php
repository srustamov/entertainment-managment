<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_contracts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index();
            $table->integer('location_id')->index();
            $table->text('description');
            $table->double('price')->nullable();
            $table->json('custom_data')->nullable();
            $table->date('start_date');
            $table->date('expire_date')->index();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('location_contracts');
    }
}
