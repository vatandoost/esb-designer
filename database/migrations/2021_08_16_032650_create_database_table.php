<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatabaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('database', function (Blueprint $table) {
            $table->uuid('id')->default(new Expression('uuid_generate_v4()'))->primary();
            $table->string('name');
            $table->tinyInteger('type');
            $table->boolean('is_template')->default(false);
            $table->foreignUuid('ns_id')->nullable();
            $table->foreignUuid('project_id')->nullable();
            $table->jsonb('config');
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
        Schema::dropIfExists('database');
    }
}
