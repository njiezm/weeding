<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('qr_codes', function (Blueprint $table) {
        $table->string('source')->change();
    });
}

public function down(): void
{
    Schema::table('qr_codes', function (Blueprint $table) {
        $table->enum('source', ['tableau', 'whatsapp', 'entree', 'eglise', 'autre'])->change();
    });
}
};
