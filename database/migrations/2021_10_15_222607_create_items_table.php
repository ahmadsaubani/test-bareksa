<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('items', function (Blueprint $table) {
//            $table->id();
//            $table->string('uuid')->unique()->index();
//            $table->foreignId('type_id')
//            ->constrained()
//            ->onDelete('cascade')->onUpdate('cascade');
//            $table->string('description')->nullable();
//            $table->decimal('price', 15,2)->unsigned();
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
