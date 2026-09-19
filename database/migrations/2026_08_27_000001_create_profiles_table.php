<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Your Name');
            $table->string('title')->default('Full-Stack Developer');
            $table->string('email')->default('hello@example.com');
            $table->string('phone')->nullable();
            $table->string('location')->default('Indonesia');
            $table->string('avatar_url')->nullable();
            $table->text('bio')->nullable();
            $table->string('cv_url')->nullable();
            $table->json('socials')->nullable(); // github, linkedin, twitter, etc.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
