<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('login_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('device', 30)->nullable();
            $table->string('platform', 30)->nullable();
            $table->string('platform_version', 30)->nullable();
            $table->string('browser', 30)->nullable();
            $table->string('browser_version', 30)->nullable();
            $table->string('ip', 39)->nullable();
            $table->string('city', 30)->nullable();
            $table->string('region_code', 5)->nullable();
            $table->string('region_name', 30)->nullable();
            $table->string('country_code', 5)->nullable();
            $table->string('country_name', 30)->nullable();
            $table->string('continent_code', 5)->nullable();
            $table->string('continent_name', 5)->nullable();
            $table->string('latitude', 20)->nullable();
            $table->string('longitude', 20)->nullable();
            $table->string('zipcode', 20)->nullable();
            $table->timestamp('created_at');

            $table->uuid('user_id')->index();
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
        Schema::dropIfExists('login_histories');
    }
}
