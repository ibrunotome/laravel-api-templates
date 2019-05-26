<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorizedDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authorized_devices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('device', 60);
            $table->string('platform', 60);
            $table->string('platform_version', 60)->nullable();
            $table->string('browser', 60);
            $table->string('browser_version', 60)->nullable();
            $table->string('city', 60)->nullable();
            $table->string('country_name', 60)->nullable();
            $table->uuid('authorization_token')->unique();
            $table->timestamp('authorized_at', 6)->nullable();
            $table->timestamp('created_at', 6);

            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authorized_devices');
    }
}
