<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('question');
            $table->string('answer');
            $table->string('picture');
            $table->unsignedInteger('type_id')->nullable();
            $table->unsignedInteger('theme_id')->nullable();
            $table->string('qcm_answer_1')->nullable()->default(null);
            $table->string('qcm_answer_2')->nullable()->default(null);
            $table->string('qcm_answer_3')->nullable()->default(null);
            $table->string('qcm_answer_4')->nullable()->default(null);
            $table->foreign('type_id')->references('id')->on('types')->onDelete('SET NULL');
            $table->foreign('theme_id')->references('id')->on('themes')->onDelete('SET NULL');
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
        Schema::drop('questions');
    }
}
