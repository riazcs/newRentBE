<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKycStatusUsersTable extends Migration
{

    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean("kyc_status")->nullable()->default(0);

        });
    }


    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->drop('kyc_status');
        });
    }
}
