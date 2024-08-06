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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // company_id companies table id
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->string('verify_token')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->string('phone');
            $table->string('company_name');
            $table->string('company_title');
            $table->integer('employees_count');
            $table->enum('status', ['ACTIVE','PASSIVE','NONVERIFY','DEMO','CANCELLED','BANNED']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      //  Schema::dropIfExists('users');
    }
};
