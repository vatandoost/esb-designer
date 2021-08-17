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
        Schema::create('runners', function (Blueprint $table) {
            $table->uuid('id')->default(new Expression('uuid_generate_v4()'))->primary();
            $table->string('name');
            $table->tinyInteger('type');
            $table->foreignUuid('project_id')->references('id')->on('projects');
            $table->foreignUuid('main_function_id')->references('id')->on('functions');
            $table->jsonb('main_function_config')->nullable();
            $table->foreignUuid('before_function_id')->references('id')->on('functions')->nullable();
            $table->jsonb('before_function_config')->nullable();
            $table->foreignUuid('after_function_id')->references('id')->on('functions')->nullable();
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
        Schema::dropIfExists('runners');
    }
}
