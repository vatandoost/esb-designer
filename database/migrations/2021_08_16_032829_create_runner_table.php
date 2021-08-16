<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRunnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('runner', function (Blueprint $table) {
            $table->uuid('id')->default(new Expression('uuid_generate_v4()'))->primary();
            $table->string('name');
            $table->tinyInteger('type');
            $table->foreignUuid('project_id');
            $table->foreignUuid('main_function_id');
            $table->jsonb('main_function_config')->nullable();
            $table->foreignUuid('before_function_id')->nullable();
            $table->jsonb('before_function_config')->nullable();
            $table->foreignUuid('after_function_id')->nullable();
            $table->jsonb('after_function_config')->nullable();
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
        Schema::dropIfExists('runner');
    }
}
