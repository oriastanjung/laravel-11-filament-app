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
            $table->string('title');
            $table->text('description');
            $table->text('information_service')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('karyawan_id')->nullable();
            $table->string('client_name');
            $table->decimal('price');
            $table->decimal('modal');
            $table->string('client_phone');
            $table->boolean('isFinish');
            $table->string('code', 16)->unique();
            $table->timestamps();
            // Foreign key constraint
            $table->foreign('karyawan_id')
                ->references('id')
                ->on('users') // Ensure this matches the name of your karyawan table
                ->onDelete('set null'); // Optionally, you can choose 'cascade' or 'restrict'
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
