<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('note_team', function (Blueprint $table) {
            $table->id();

            $table->foreignId('note_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('team_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unique(['note_id', 'team_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('note_team');
    }
};