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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('staff_id')->unique();
            $table->string('role');
            $table->date('date_of_joining')->nullable();
            $table->string('pan_number')->nullable();

            $table->string('name');
            $table->string('father_name')->nullable();
            $table->string('gender');
            $table->date('date_of_birth')->nullable();
            $table->string('qualification')->nullable();
            $table->string('work_experience')->nullable();
            $table->text('note')->nullable();

            $table->string('email')->unique();
            $table->string('mobile_number');
            $table->text('address')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
