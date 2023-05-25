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
        Schema::create('reported_incidents', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->string('latitude');
            $table->string('longitude');
            $table->integer('incident_id')->unsigned();
            $table->foreign('incident_id')->references('id')->on('incidents')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reported_incidents');
    }
};
