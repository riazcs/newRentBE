<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGoogleMapToAddressAdditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('address_additions', function (Blueprint $table) {
            //
            $table->decimal('latitude ', 14, 2)->nullable();
            $table->decimal('longitude  ', 14, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('address_additions', function (Blueprint $table) {
            //
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
        });
    }
}