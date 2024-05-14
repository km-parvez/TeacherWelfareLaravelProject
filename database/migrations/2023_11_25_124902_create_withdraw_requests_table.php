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
        Schema::create('withdraw_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->double('amount')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('type');
            $table->text('details')->nullable();
            $table->text('current_payscale')->nullable();
            $table->text('requested_amount')->nullable();
            $table->string('total_salary_withdraw')->nullable();
            $table->string('requested_for_name')->nullable();
            $table->date('requested_for_date_of_birth')->nullable();
            $table->string('relation')->nullable();
            $table->text('education_details')->nullable();
            $table->text('education_details_2')->nullable();
            $table->text('disease_details')->nullable();
            $table->text('old_scholarship_details')->nullable();
            $table->text('latest_payment_receipt_details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraw_requests');
    }
};
