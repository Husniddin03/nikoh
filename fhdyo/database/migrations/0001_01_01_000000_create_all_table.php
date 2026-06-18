<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Admins table
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('password');
            $table->boolean('is_super_admin')->default(false);
            $table->timestamps();
        });

        // 2. Users table (name va phone_number olib tashlandi)
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jshshir')->unique();
            $table->enum('gender', ['male', 'female']);
            $table->integer('test_count')->default(5);
            $table->timestamps();
        });

        // 3. Units table
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins');
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('category', ['ajrim', 'nikoh']);
            $table->timestamps();
        });

        // 4. Questions table
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('admins');
            $table->text('question');
            $table->boolean('is_critical')->default(false);
            $table->timestamps();
        });

        // 5. Test Sessions table (Sinxron testlash uchun)
        Schema::create('test_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('initiator_id')->constrained('users');
            $table->foreignId('partner_id')->constrained('users');
            $table->enum('category', ['ajrim', 'nikoh'])->default('nikoh');
            $table->json('question_ids'); // Tanlangan savollar tartibi: [1, 5, 8...]
            $table->enum('status', ['waiting', 'in_progress', 'completed'])->default('waiting');
            $table->longText('ai_result')->nullable();
            $table->boolean('ai_generated')->default(false);
            $table->timestamps();
        });

        // 6. Results table
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('test_sessions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('question_id')->constrained('questions');
            $table->boolean('answer');
            $table->timestamps();
        });

        // 7. Unit Scores table (Analitika uchun)
        Schema::create('unit_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('test_sessions')->onDelete('cascade');
            $table->foreignId('unit_id')->constrained('units');
            $table->float('match_percentage');
            $table->text('interpretation')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_scores');
        Schema::dropIfExists('results');
        Schema::dropIfExists('test_sessions');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('units');
        Schema::dropIfExists('users');
        Schema::dropIfExists('admins');
    }
};