<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();

            // 座席コード
            $table->string('code');
            // 部屋
            $table->unsignedBigInteger('room_id');
            $table->foreign('room_id')->references('id')->on('rooms');

            // 座席位置（row: 前から、col: 左から）
            $table->integer('row')->nullable();
            $table->integer('col')->nullable();
            // 座席 URL
            $table->string('url')->nullable();
            // 座席 QR コード
            $table->text('qrcode')->nullable();
            // 優先席
            $table->boolean('is_priority')->default(false);
            // メモ
            $table->text('memo')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seats');
    }
}
