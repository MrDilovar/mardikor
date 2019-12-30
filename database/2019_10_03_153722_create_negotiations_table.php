<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNegotiationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('negotiations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('resume_id');
            $table->foreign('resume_id')->references('id')->on('resumes');
            $table->text('resume_letter');
            $table->integer('vacancy_id');
            $table->foreign('vacancy_id')->references('id')->on('vacancies');
            $table->text('vacancy_letter');
            $table->integer('status');
            $table->foreign('status')->references('id')->on('negotiation_statuses');
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
        Schema::dropIfExists('negotiations');
    }
}
