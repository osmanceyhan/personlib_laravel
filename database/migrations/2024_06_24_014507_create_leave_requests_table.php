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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->string('id');
			$table->foreignId('user_id')->constrained();
			$table->foreignId('leave_type_id')->constrained();
			$table->date('start_date');
			$table->string('start_time');
			$table->date('end_date');
			$table->string('end_time');
			$table->string('comment');
			$table->foreignId('person_replace_id')->constrained();
			$table->date('return_date');
			$table->string('return_time');
			$table->timestamp('created_at');
			$table->date('updated_at');
			$table->timestamp('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
