<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetTableSequences extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:reset-sequences';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset sequences for all tables in the database.';

    public function handle()
    {
        $query = "
            DO
            $$
            DECLARE
                rec RECORD;
            BEGIN
                FOR rec IN (
                    SELECT table_name 
                    FROM information_schema.columns 
                    WHERE column_name = 'id' AND table_schema = 'public' AND data_type IN ('integer', 'bigint')
                )
                LOOP
                    EXECUTE 'SELECT setval(pg_get_serial_sequence(''' || rec.table_name || ''', ''id''), (SELECT COALESCE(MAX(id)+1, 1) FROM ' || rec.table_name || '))';
                END LOOP;
            END;
            $$;
        ";
    
        DB::statement($query);
    
        $this->info('Sequences reset successfully.');
    }
    
}
