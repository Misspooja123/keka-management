<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('marksheets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key to users table
            $table->text('bio')->nullable();
            $table->integer('mathematics')->nullable();
            $table->integer('science')->nullable();
            $table->integer('socialscience')->nullable();
            $table->integer('english')->nullable();
            $table->integer('gujarati')->nullable();
            $table->integer('hindi')->nullable();
            $table->integer('total')->nullable();
            $table->float('percentage')->nullable();
            $table->enum('status', [0, 1]);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marksheets');
    }
};
