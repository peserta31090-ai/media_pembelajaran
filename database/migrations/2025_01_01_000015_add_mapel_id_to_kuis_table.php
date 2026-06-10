<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kuis', function (Blueprint $table) {
            $table->foreignId('mapel_id')->nullable()->constrained('mapels')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('kuis', function (Blueprint $table) {
            $table->dropConstrainedForeignId('mapel_id');
        });
    }
};
