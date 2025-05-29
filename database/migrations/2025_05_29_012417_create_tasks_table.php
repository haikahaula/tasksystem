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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assigned_to_id')->nullable();
            $table->string('assigned_to_type')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('due_date');
            $table->string('document')->nullable();
            $table->timestamps();
            $table->foreign('assigned_to_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
