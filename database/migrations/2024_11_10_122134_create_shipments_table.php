<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar las migraciones.
     */
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->required();
            $table->foreignId('transporter_id')->required();
            $table->foreignId('package_id')->required();
            $table->string('source_address')->required();
            $table->string('destination_address')->required();
            $table->string('status')->required();
            $table->float('amount')->required();
            $table->datetime('creation_date')->required();
            $table->datetime('estimated_delivery')->required();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('transporter_id')->references('id')->on('transporters')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('package_id')->references('id')->on('packages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Revertir las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
