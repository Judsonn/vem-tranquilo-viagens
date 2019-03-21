<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrotasOnibusTable extends Migration
{
    private $databaseName = "frotas_onibus";

    /**
     * Run the migrations.
     *
     * @return void
     */


    public function up()
    {
        Schema::create($this->databaseName, function (Blueprint $table) {
            $table->unsignedBigInteger('idfrota');
            $table->foreign('idfrota')->references('id')->on('frotas');

            $table->unsignedBigInteger('idonibus');
            $table->foreign('idonibus')->references('id')->on('onibus');
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
        Schema::dropIfExists($this->databaseName);
    }
}

