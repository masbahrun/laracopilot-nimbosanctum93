<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('biolink_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('biolink_id')->constrained()->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('country', 2)->nullable();
            $table->string('city')->nullable();
            $table->string('device_type', 20)->nullable();
            $table->string('browser', 50)->nullable();
            $table->string('referrer')->nullable();
            $table->timestamps();
            
            $table->index(['biolink_id', 'created_at']);
        });
        
        Schema::create('bio_item_clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bio_item_id')->constrained()->onDelete('cascade');
            $table->foreignId('biolink_id')->constrained()->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('country', 2)->nullable();
            $table->string('device_type', 20)->nullable();
            $table->timestamps();
            
            $table->index(['bio_item_id', 'created_at']);
            $table->index(['biolink_id', 'created_at']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bio_item_clicks');
        Schema::dropIfExists('biolink_views');
    }
};