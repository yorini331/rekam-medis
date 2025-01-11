<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnPoliklinikIdFromRekamMedisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rekam_medis', function (Blueprint $table) {
            $table->dropForeign(['poliklinik_id']);
            $table->dropColumn('poliklinik_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rekam_medis', function (Blueprint $table) {
           $table->unsignedBigInteger('poliklinik_id');
           $table->foreign('poliklinik_id')->references('id')->on('poliklinik')->onDelete('cascade');
        });
    }
}
