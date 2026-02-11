<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('biolinks', function (Blueprint $table) {
            $table->string('layout')->default('default')->after('custom_metatags');
        });
    }
    
    public function down()
    {
        Schema::table('biolinks', function (Blueprint $table) {
            $table->dropColumn('layout');
        });
    }
};