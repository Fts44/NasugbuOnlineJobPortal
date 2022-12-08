<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_post', function (Blueprint $table) {
            $table->id('jp_id');
            $table->integer('jp_category');
            $table->string('jp_title');
            $table->longText('jp_qualification');
            $table->longText('jp_description');
            $table->integer('jp_salary');
            $table->boolean('jp_is_deleted')->default('0');
            $table->date('jp_date')->default(DB::raw('NOW()'));
            $table->integer('jp_acc_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_post');
    }
}
