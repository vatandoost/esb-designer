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
        Schema::create('databases', function (Blueprint $table) {
            $table->uuid('id')->default(new Expression('uuid_generate_v4()'))->primary();
            $table->string('name');
            $table->string('host');
            $table->string('port')->nullable();
            $table->string('db');
            $table->string('username');
            $table->string('password');
            $table->string('schema')->nullable();
            $table->tinyInteger('type');
            $table->boolean('is_template')->default(false);
            $table->foreignUuid('namespace_id')->nullable();
            $table->foreignUuid('project_id')->nullable();
            $table->foreign('namespace_id')->references('id')->on('namespaces');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->jsonb('config')->nullable();
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
        Schema::dropIfExists('databases');
    }
}
