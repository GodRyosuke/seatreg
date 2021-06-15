<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFullnameToLocationInSeats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seats', function (Blueprint $table) {
            $table->renameColumn('fullname', 'location');//<-記述
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seats', function (Blueprint $table) {
            $table->renameColumn('location', 'fullname');//<-記述
        });
    }
}
