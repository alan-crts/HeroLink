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
        Schema::create('users_incidents', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();

            $table->integer('incident_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')

                ->onDelete('cascade');

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
        Schema::dropIfExists('users_incidents');
    }
};
