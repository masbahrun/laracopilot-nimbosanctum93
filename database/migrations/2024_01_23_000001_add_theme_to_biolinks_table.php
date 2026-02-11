<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('biolinks', function (Blueprint $table) {
            $table->string('theme_color')->default('#667eea')->after('layout');
        });
    }
    
    public function down()
    {
        Schema::table('biolinks', function (Blueprint $table) {
            $table->dropColumn('theme_color');
        });
    }
};