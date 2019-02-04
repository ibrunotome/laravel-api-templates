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

            $table->string('device', 30);
            $table->string('platform', 30);
            $table->string('platform_version', 30)->nullable();
            $table->string('browser', 30);
            $table->string('browser_version', 30)->nullable();
            $table->string('city', 30)->nullable();
            $table->string('country_name', 30)->nullable();
            $table->uuid('authorization_token');
            $table->timestamp('authorized_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('authorized_devices');
    }
}
