<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bio_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('biolink_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['bio', 'link', 'image', 'text']);
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->string('url', 500)->nullable();
            $table->string('icon_path')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bio_items');
    }
};