<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_metas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('meta_name')->unique();
            $table->string('meta_value')->nullable();
            $table->text('meta_content')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_type')->nullable();
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
        Schema::dropIfExists('home_metas');
    }
}
