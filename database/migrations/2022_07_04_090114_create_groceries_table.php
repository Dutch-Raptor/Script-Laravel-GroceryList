<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('groceries', function (Blueprint $table) {
            $table->id();
            $table->foreignId("category_id");
            $table->string('name');
            $table->double('price');
            $table->double('quantity')->default(0);
            $table->boolean('purchased')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('groceries');
    }
};
