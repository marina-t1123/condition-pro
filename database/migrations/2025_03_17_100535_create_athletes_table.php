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
        Schema::create('athletes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onUpdate('cascade')->onDelete('cascade')->comment('チームID');
            $table->foreignId('sex_id')->constrained()->comment('1:男性2:女性3:その他');
            $table->string('name')->comment('選手名');
            $table->date('birthday')->comment('誕生日');
            $table->text('memo')->nullable()->comment('備考');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('athletes');
    }
};
