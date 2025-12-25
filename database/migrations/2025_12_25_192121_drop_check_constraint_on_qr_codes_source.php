<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE qr_codes DROP CONSTRAINT IF EXISTS qr_codes_source_check');
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE qr_codes
            ADD CONSTRAINT qr_codes_source_check
            CHECK (source IN ('tableau', 'whatsapp', 'entree', 'eglise', 'autre'))
        ");
    }
};
