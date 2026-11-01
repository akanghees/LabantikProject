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
        Schema::create('inventory_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_item_id')->constrained('inventory_items')->onDelete('restrict');
            $table->foreignId('member_id')->nullable()->constrained('members')->nullOnDelete();
            $table->string('borrower_name', 120);
            $table->unsignedInteger('quantity');
            $table->date('loaned_at');
            $table->date('due_at')->nullable();
            $table->date('returned_at')->nullable();
            $table->enum('condition_returned', ['baik', 'rusak_ringan', 'rusak_berat', 'perbaikan'])->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_loans');
    }
};
