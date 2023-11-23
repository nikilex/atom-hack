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
        Schema::create('operation_queue', function (Blueprint $table) {
            $table->foreignId('operation_id')
                ->references('id')
                ->on('operations')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreignId('queue_id')
                ->references('id')
                ->on('queues')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->timestamps();
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
