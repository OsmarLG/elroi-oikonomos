<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('note_user', function (Blueprint $table) {

            // Rol del colaborador
            $table->enum('role', ['viewer', 'editor'])
                ->default('viewer')
                ->after('user_id');

            // Auditoría de invitación
            $table->timestamp('invited_at')
                ->nullable()
                ->after('role');

            $table->timestamp('accepted_at')
                ->nullable()
                ->after('invited_at');
        });
    }

    public function down(): void
    {
        Schema::table('note_user', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'invited_at',
                'accepted_at',
            ]);
        });
    }
};
