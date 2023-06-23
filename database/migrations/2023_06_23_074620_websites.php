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
        //websites

        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->string('domain');
            $table->bigInteger('source_id');
            $table->bigInteger('server_id');
            $table->string('user_admin');
            $table->longText('password_admin');
            $table->bigInteger('data_addon_id');
            $table->bigInteger('theme');
            $table->longText('token');
            $table->bigInteger('package_id');
            $table->timestamps();
            $table->dateTime('expired_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('websites');
    }
};
