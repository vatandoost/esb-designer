<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFunctionParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('function_params', function (Blueprint $table) {
            $table->uuid('id')->default(new Expression('uuid_generate_v4()'))->primary();
            $table->foreignUuid('function_id')->references('id')->on('functions');
            $table->foreignUuid('parent_id')->nullable();
            $table->string('name');
            $table->tinyInteger('dir_type');
            $table->string('value_type');
            $table->string('path')->nullable();
            $table->boolean('is_required')->default(false);
            $table->boolean('is_assignable')->default(true);
            $table->text('default')->nullable();
            $table->jsonb('formula')->nullable();
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
        Schema::dropIfExists('function_params');
    }
}
