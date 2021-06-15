<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();

            // 部屋名
            $table->string('name');
            // 教室コード
            $table->string('code');
            // 建物名称
            $table->unsignedBigInteger('building_id')->nullable();
            $table->foreign('building_id')->references('id')->on('buildings');
            // 階
            $table->unsignedInteger('floor')->nullable();

            // 部屋構成（行、列）
            $table->unsignedInteger('rows')->nullable();
            $table->unsignedInteger('cols')->nullable();

            // 定員（平常時、試験時、コロナ対策）
            $table->unsignedInteger('capacity')->nullable();
            $table->unsignedInteger('capacity_exam')->nullable();
            $table->unsignedInteger('capacity_covid')->nullable();

            // 作成者（管理者の場合は NULL）
            $table->string('creator')->nullable();
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
        Schema::dropIfExists('rooms');
    }
}
