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
        Schema::create('tbl_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periode_id')->nullable();
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->string('nama')->nullable();
            $table->bigInteger('harga')->nullable();
            $table->bigInteger('total_pengerjaan_item')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->date('deleted_at')->nullable();
            $table->timestamps();

            $table->foreign('periode_id')
                ->references('id')
                ->on('tbl_periode')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('barang_id')
                ->references('id')
                ->on('tbl_barang')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_item');
    }
};
