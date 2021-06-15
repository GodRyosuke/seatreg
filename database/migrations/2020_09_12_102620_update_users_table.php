<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Users テーブルの更新
        Schema::table('users', function (Blueprint $table) {
        	$table->string('ocuid')->after('id')->unique();
        	$table->string('primaryid')->after('ocuid')->unique();
            $table->string('kana')->after('name')->nullable();
            $table->string('romaji')->after('kana')->nullable();
            $table->string('code_u')->before('password')->nullable();
            $table->string('name_u')->before('password')->nullable();
            $table->string('code_e')->before('password')->nullable();
            $table->string('name_e')->before('password')->nullable();
            $table->string('code_p')->before('password')->nullable();
            $table->string('name_p')->before('password')->nullable();
            $table->string('code_d')->before('password')->nullable();
            $table->string('name_d')->before('password')->nullable();
            $table->dateTime('started_at')->before('created_at')->nullable();
            $table->dateTime('moved_at')->before('created_at')->nullable();
            $table->dateTime('expired_by')->before('created_at')->nullable();
  
            $table->string('api_token', 80)->after('password')
                ->unique()
                ->nullable()
                ->default(null);

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
        //
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('ocuid');
            $table->dropColumn('primaryid');
            $table->dropColumn('name');
            $table->dropColumn('kana');
            $table->dropColumn('romaji');
            $table->dropColumn('code_u');
            $table->dropColumn('name_u');
            $table->dropColumn('code_p');
            $table->dropColumn('name_p');
            $table->dropColumn('code_d');
            $table->dropColumn('name_d');
            $table->dropColumn('started_at');
            $table->dropColumn('moved_at');
            $table->dropColumn('expired_by');
        });
    }
}
