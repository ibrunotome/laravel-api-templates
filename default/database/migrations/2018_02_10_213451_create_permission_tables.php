<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('permission.table_names');

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('name');
            $table->string('guard_name')->default('api');
            $table->timestamps();
        });

        Schema::create($tableNames['roles'], function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('name');
            $table->string('guard_name')->default('api');
            $table->timestamps();
        });

        Schema::create($tableNames['model_has_permissions'],
            function (Blueprint $table) use ($tableNames) {
                $table->increments('id');
                $table->uuid('permission_id');
                $table->string('model_type');
                $table->uuid('model_id');
                $table->index([
                    'model_type',
                    'model_id'
                ]);

                $table->foreign('permission_id')
                    ->references('id')
                    ->on($tableNames['permissions'])
                    ->onDelete('cascade');
            });

        Schema::create($tableNames['model_has_roles'],
            function (Blueprint $table) use ($tableNames) {
                $table->increments('id');
                $table->uuid('role_id');
                $table->string('model_type');
                $table->uuid('model_id');
                $table->index([
                    'model_type',
                    'model_id'
                ]);

                $table->foreign('role_id')
                    ->references('id')
                    ->on($tableNames['roles'])
                    ->onDelete('cascade');
            });

        Schema::create($tableNames['role_has_permissions'],
            function (Blueprint $table) use ($tableNames) {
                $table->increments('id');
                $table->uuid('permission_id');
                $table->uuid('role_id');

                $table->foreign('permission_id')
                    ->references('id')
                    ->on($tableNames['permissions'])
                    ->onDelete('cascade');

                $table->foreign('role_id')
                    ->references('id')
                    ->on($tableNames['roles'])
                    ->onDelete('cascade');

                app('cache')->forget('spatie.permission.cache');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('permission.table_names');

        Schema::dropIfExists($tableNames['role_has_permissions']);
        Schema::dropIfExists($tableNames['model_has_roles']);
        Schema::dropIfExists($tableNames['model_has_permissions']);
        Schema::dropIfExists($tableNames['roles']);
        Schema::dropIfExists($tableNames['permissions']);
    }
}
