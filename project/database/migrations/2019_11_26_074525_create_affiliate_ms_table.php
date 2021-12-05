<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffiliateMsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_ms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',100)->unique();
            $table->string('ref_username')->nullable();
            $table->unsingedInteger('user_id');
            $table->string('fbprofile');
            $table->string('sellmethod',191)->nullable();
            $table->string('usertype');
            $table->string('shopname')->nullable();
            $table->string('location')->nullable();
            $table->string('businesstype')->nullable();
            $table->tinyInteger('active')->default(0);
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
        Schema::dropIfExists('affiliate_ms');
    }
}
