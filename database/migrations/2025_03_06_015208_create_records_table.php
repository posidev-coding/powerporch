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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->unsignedMediumInteger('team_id');
            $table->enum('scope', ['overall', 'home', 'away']);
            $table->string('summary');
            $table->unsignedTinyInteger('wins');
            $table->unsignedTinyInteger('losses');
            $table->decimal('pct', total: 4, places: 3);
            $table->timestamps();
            $table->unique(['team_id', 'scope']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
