<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name');
            $table->string('anti_phishing_code', 20)->nullable();
            $table->string('email_token_confirmation', 36)->nullable();
            $table->string('email_token_disable_account', 36)->nullable();
            $table->boolean('google2fa_enable')->default(false);
            $table->string('google2fa_secret')->nullable();
            $table->text('google2fa_url')->nullable();
            $table->string('locale', 5)->default('en_US');
            $table->timestamps();

            $table->uuid('user_id')->unique();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
