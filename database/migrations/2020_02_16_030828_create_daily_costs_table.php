<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_costs', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->unsignedInteger('payer');
            $table->string('payfor')->nullable();
            $table->unsignedInteger('category')->nullable();
            $table->integer('total')->nullable();
            $table->date('date')->nullable();
            $table->integer('percent_per_one')->nullable();
            $table->integer('percent_per_two')->nullable();
            $table->string('image')->null();
            $table->integer('is_together')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_costs');
    }
}
