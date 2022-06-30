<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditColumnTwoInTelemetri extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('telemetri', function (Blueprint $table) {
            $table->decimal('beras', 8, 3)->nullable()->comment('liter')->change();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->decimal('dedak', 8, 3)->nullable()->comment('liter');
            $table->decimal('bensin_pakai', 8, 3)->nullable()->comment('liter');
            $table->bigInteger('waktu_penggilingan')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('telemetri', function (Blueprint $table) {
            //
        });
    }
}
