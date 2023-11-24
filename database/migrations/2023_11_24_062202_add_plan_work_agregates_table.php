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
        Schema::create('plan_work_agregates', function (Blueprint $table) {
            $table->id();
            $table->string('equipment')->nullable();
            $table->string('temp')->nullable();
            $table->timestamp('start')->nullable();
            $table->timestamp('stop')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
