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
        Schema::create('user_infos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->string('id');
			$table->foreignId('user_id')->constrained();
			$table->foreignId('company_id')->constrained();
			$table->string('title');
			$table->date('start_date');
			$table->string('contract_type');
			$table->date('end_date');
			$table->string('work_type');
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
        Schema::dropIfExists('user_infos');
    }
};
