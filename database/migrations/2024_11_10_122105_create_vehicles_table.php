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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transporter_id')->required();
            $table->string('license_plate')->required()->max(10);
            $table->string('transport_type')->required()->max(255);
            $table->string('brand')->required()->max(50);
            $table->string('model')->required()->max(50);
            $table->integer('year')->required();
            $table->string('status')->required()->max(50);
            $table->timestamps();

            $table->foreign('transporter_id')->references('id')->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
