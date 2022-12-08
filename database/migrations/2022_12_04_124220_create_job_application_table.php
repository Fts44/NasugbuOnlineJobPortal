<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_application', function (Blueprint $table) {
            $table->id('ja_id');
            $table->string('ja_filename');
            $table->date('ja_date')->default(DB::raw('NOW()'));
            $table->integer('ja_status')->default('0');
            $table->datetime('ja_datetime')->nullable();
            $table->integer('ja_result')->nullable();
            $table->integer('jp_id');
            $table->integer('ja_applicant_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_application');
    }
}
