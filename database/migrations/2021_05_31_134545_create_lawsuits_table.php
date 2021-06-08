<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLawsuitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lawsuits', function (Blueprint $table) {
            $table->id();
            $table->string('lawsuit_number');
            $table->string('claimant'); /* plaintiff */
            $table->string('defendant');
            $table->unsignedBigInteger('type_id')->nullable();
            $table->unsignedBigInteger('court_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->date('deposit_date')->nullable();
            $table->integer('deposit_value')->nullable();
            $table->enum('deposit_currency',['jod','usd','ils'])->nullable();
            $table->boolean('is_archived')->default(0); /* active lawsuit */
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->longText('details')->nullable();
            $table->softDeletes();
            $table->timestamps();

            //foreign keys
            $table->foreign('parent_id')->references('id')->on('lawsuits')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lawsuits');
    }
}
