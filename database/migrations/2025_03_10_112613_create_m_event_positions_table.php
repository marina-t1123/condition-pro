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
        Schema::create('m_event_positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('m_event_id')->constrained()->onUpdate('cascade')->comment('種目マスタID');
            // $table->unsignedBigInteger('m_event_id');
            // $table->foreign('m_event_id')->references('id')->on('m_events');
            $table->string('event_position_name')->comment('ポジション・階級名');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_event_positions');
    }
};
