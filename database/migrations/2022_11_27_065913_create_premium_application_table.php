<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePremiumApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('premium_application', function (Blueprint $table) {
            $table->id('pa_id');
            $table->string('pa_file');
            $table->date('pa_date')->default(DB::raw('NOW()'));
            $table->date('pa_validity')->nullable();
            $table->boolean('pa_status')->default(0);
            $table->integer('acc_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('premium_application');
    }
}
