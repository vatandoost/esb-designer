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
            $table->foreignUuid('function_id');
            $table->string('name');
            $table->tinyInteger('dir_type');
            $table->tinyInteger('value_type');
            $table->boolean('is_public')->default(true);
            $table->boolean('is_initializable')->default(true);
            $table->text('default')->nullable();
            $table->text('formula')->nullable();
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
