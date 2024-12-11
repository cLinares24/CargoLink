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
        Schema::create('pays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->required();
            $table->string('transaction_id')->required();
            $table->string('status')->required();
            $table->float('amount')->required();
            $table->string('payment_method')->nullable();
            $table->timestamps();

            $table->foreign('shipment_id')->references('id')->on('shipments')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pays');
    }
};
