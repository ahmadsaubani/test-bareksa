<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_references', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique()->index();
            $table->bigInteger("ref_id")->index();
            $table->string("ref_model")->index();
            $table->string("ref_class")->index();
            $table->string("tag_id")->nullable();
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
        Schema::dropIfExists('news_references');
    }
}
