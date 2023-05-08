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
        Schema::table('tbl_transaksi_item', function (Blueprint $table) {
            $table->bigInteger('before_total_tmp_barang')->nullable();
            $table->bigInteger('after_total_tmp_barang')->nullable();
            $table->bigInteger('selisih_total_tmp_barang')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_transaksi_item', function (Blueprint $table) {
            $table->dropColumn(['before_total_tmp_barang', 'after_total_tmp_barang', 'selisih_total_tmp_barang']);
        });
    }
};
