<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender', ['male','female'])->default('male');
            $table->enum('status_adopt', ['ready','adopted'])->default('ready');
            $table->string('certificate');
            $table->string('color');
            $table->date('date_birth')->nullable();
            $table->string('weight')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('categories_id')->default(1);
            $table->foreign('categories_id')->references('id')->on('categories');
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
        Schema::dropIfExists('pets');
    }
};
