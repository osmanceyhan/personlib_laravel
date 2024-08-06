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
        Schema::create('payment_requests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->string('id');
			$table->foreignId('user_id')->constrained();
			$table->string('payment_type');
			$table->string('amount');
			$table->date('used_date');
			$table->string('attachment');
			$table->string('comment');
			$table->string('tax_rate');
			$table->date('receipt_date');
			$table->date('start_date');
			$table->string('start_time');
			$table->string('hour');
			$table->string('minute');
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
        Schema::dropIfExists('payment_requests');
    }
};
