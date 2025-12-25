<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Transformer la colonne source en varchar (PostgreSQL)
        DB::statement("
            ALTER TABLE qr_codes
            ALTER COLUMN source TYPE VARCHAR(255) USING source::text;
        ");
    }

    public function down(): void
    {
        // Revenir à l'enum avec check constraint
        DB::statement("
            ALTER TABLE qr_codes
            ALTER COLUMN source TYPE text USING source::text;
        ");

        DB::statement("
            ALTER TABLE qr_codes
            ADD CONSTRAINT qr_codes_source_check
            CHECK (source IN ('tableau', 'whatsapp', 'entree', 'eglise', 'autre'))
        ");
    }
};
