<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOcumailToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // add fields on OCUMail
            $table->string('ocumail')->before('email')->nullable(); // o365mailaddress
            $table->string('ocualias')->after('ocumail')->nullable(); // o365aliasname
            $table->boolean('o365flag')->after('name_d')->nullable(); // o365proplusflg
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('ocumail');
            $table->dropColumn('ocualias');
            $table->dropColumn('o365flag');

        });
    }
}
