<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variables', function (Blueprint $table) {
            $table->uuid('id')->default(new Expression('uuid_generate_v4()'))->primary();
            $table->string('name');
            $table->text('value')->nullable();
            $table->tinyInteger('type');
            $table->tinyInteger('env')->nullable();
            $table->nullableUuidMorphs('object');
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
        Schema::dropIfExists('variables');
    }
}
