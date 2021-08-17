<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNamespaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('namespaces', function (Blueprint $table) {
            $table->uuid('id')->default(new Expression('uuid_generate_v4()'))->primary();
            //$table->foreignId('owner_id')->references('id')->on('users');
            $table->string('name');
            $table->jsonb('ns_requirements')->nullable();
            $table->jsonb('provider_requirements')->nullable();
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
        Schema::dropIfExists('namespaces');
    }
}
