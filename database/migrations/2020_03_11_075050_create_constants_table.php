<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConstantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('constants', function (Blueprint $table) {
            $table->id();
            $table->integer('sort')->nullable();
            $table->string('groups')->nullable();
            $table->string('name')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('key')->nullable();
            $table->string('value')->nullable();
            $table->string('info')->nullable();
            $table->string('class')->nullable();
            $table->tinyInteger('ison');
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
        Schema::dropIfExists('constants');
    }
}
