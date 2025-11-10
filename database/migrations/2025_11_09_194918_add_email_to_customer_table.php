<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailToCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('customer', function (Blueprint $table) {
        $table->string('Email')->nullable()->after('Address');
    });
}


public function down()
{
    Schema::table('customer', function (Blueprint $table) {
        $table->dropColumn('Email');
    });
}
}
