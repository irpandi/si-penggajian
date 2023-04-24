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
        Schema::create('tbl_tunjangan', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->unsignedBigInteger('data_gaji_id')->nullable();
            $table->bigInteger('jumlah')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

            $table->foreign('data_gaji_id')
                ->references('id')
                ->on('tbl_data_gaji')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_tunjangan');
    }
};
