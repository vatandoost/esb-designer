<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNsDbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('database_namespace', function (Blueprint $table) {
            //$table->uuid('id')->default(new Expression('uuid_generate_v4()'))->primary();
            $table->foreignUuid('database_id')->references('id')->on('databases');
            $table->foreignUuid('namespace_id')->references('id')->on('namespaces');
            $table->primary(['database_id', 'namespace_id']);
            $table->string('comment')->nullable();
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
        Schema::dropIfExists('database_namespace');
    }
}
