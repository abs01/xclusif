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
    Schema::table('xcoins', function (Blueprint $table) {
        $table->foreignId('liked_by_user_id')
            ->after('user_id')
            ->constrained('users')
            ->cascadeOnDelete();

        $table->unique(['liked_by_user_id', 'post_id']);
    });
}

public function down(): void
{
    Schema::table('xcoins', function (Blueprint $table) {
        $table->dropForeign(['liked_by_user_id']);
        $table->dropUnique(['liked_by_user_id', 'post_id']);
        $table->dropColumn('liked_by_user_id');
    });
}
};
