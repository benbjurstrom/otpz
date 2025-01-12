<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('otps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('code');
            $table->tinyInteger('attempts')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->boolean('remember')->default(false);
            $table->ipAddress('ip_address');
            $table->timestamps();
        });
    }
};
