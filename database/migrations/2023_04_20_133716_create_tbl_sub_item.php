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
        Schema::create('tbl_sub_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periode_id')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->bigInteger('total_pengerjaan_item')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

            $table->foreign('periode_id')
                ->references('id')
                ->on('tbl_periode')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');

            $table->foreign('item_id')
                ->references('id')
                ->on('tbl_item')
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
        Schema::dropIfExists('tbl_sub_item');
    }
};
