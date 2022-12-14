<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id('acc_id');
            $table->string('acc_classification');
            $table->boolean('acc_verified_status');
            $table->string('acc_password');
            $table->string('acc_firstname')->nullable();
            $table->string('acc_middlename')->nullable();
            $table->string('acc_lastname')->nullable();
            $table->string('acc_suffixname')->nullable();
            $table->string('acc_email')->unique();
            $table->string('acc_phone')->nullable();
            $table->date('acc_birthdate')->nullable();
            $table->string('acc_sex')->nullable();
            $table->integer('acc_add_id')->nullable()->unique();
            $table->dateTime('acc_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));       
            $table->string('acc_biz_name')->nullable();
            $table->string('acc_biz_logo')->nullable();
            $table->string('acc_biz_add_id')->nullable();
            $table->string('acc_biz_tel')->nullable();
            $table->string('acc_biz_phone')->nullable();
            $table->integer('acc_login_attempts')->nullable();
            $table->date('acc_login_attempts_date')->nullable();
            $table->boolean('acc_blocked_status')->default('0');
            $table->boolean('acc_banned_status')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
