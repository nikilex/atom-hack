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
        Schema::table('equipments', function (Blueprint $table) {
            $table->string('temp_actual')->nullable();
            $table->string('temp_dopustimie')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipments', function (Blueprint $table) {
            //
        });
    }
};
