<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDbEntityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('db_entities', function (Blueprint $table) {
            $table->uuid('id')->default(new Expression('uuid_generate_v4()'))->primary();
            $table->string('name');
            $table->foreignUuid('database_id')->references('id')->on('databases');
            $table->jsonb('indexes')->nullable();
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
        Schema::dropIfExists('db_entities');
    }
}
