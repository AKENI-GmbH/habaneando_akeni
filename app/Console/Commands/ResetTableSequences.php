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

        $tables = [
            'headers'                    =>    'headers_id_seq',
            'rate_categories'            =>    'rate_categories_id_seq1',
            'club_members'               =>    'club_members_id_seq1',
            'club_rates'                 =>    'club_rates_id_seq1',
            'contact_messages'           =>    'contact_messages_id_seq1',
            'course_cards'               =>    'course_cards_id_seq1',
            'course_categories'          =>    'course_categories_id_seq1',
            'course_subcategories'       =>    'course_subcategories_id_seq1',
            // 'course_subscriptions'       =>    'course_subscriptions_id_seq1',
            'courses'                    =>    'courses_id_seq1',
            'customers'                  =>    'customers_id_seq1',
            'editions'                   =>    'editions_id_seq1',
            'event_subscriptions'        =>    'event_subscriptions_id_seq',
            'events'                     =>    'events_id_seq',
            'failed_jobs'                =>    'failed_jobs_id_seq1',
            'locations'                  =>    'locations_id_seq1',
            'migrations'                 =>    'migrations_id_seq1',
            'pages'                      =>    'pages_id_seq1',
            'personal_access_tokens'     =>    'personal_access_tokens_id_seq1',
            'posts'                      =>    'posts_id_seq1',
            // 'roles'                      =>    'roles_id_seq1',
            'services'                   =>    'services_id_seq1',
            'tags'                       =>    'tags_id_seq1',
            'teachers'                   =>    'teachers_id_seq1',
            'ticket_types'               =>    'ticket_types_id_seq',
            'course_plans'               =>    'course_plans_id_seq1',
            'tickets'                    =>    'tickets_id_seq',
            'trip_editions'              =>    'trip_editions_id_seq1',
            'trip_galleries'             =>    'trip_galleries_id_seq1',
            'trip_instructors'           =>    'trip_instructors_id_seq1',
            'trip_subscriptions'         =>    'trip_subscriptions_id_seq1',
            'trip_tickets'               =>    'trip_tickets_id_seq1',
            'trips'                      =>    'trips_id_seq1',
            'users'                      =>    'users_id_seq1',
        ];

        foreach ($tables as $table => $sequence) {
            $maxId = DB::table($table)->max('id');
            $nextId = $maxId + 1;

            DB::statement("ALTER SEQUENCE $sequence RESTART WITH $nextId");

            $this->info("The sequence for $table has been reset successfully.");
        }

        
        // $query = "
        //     DO
        //     $$
        //     DECLARE
        //         rec RECORD;
        //     BEGIN
        //         FOR rec IN (
        //             SELECT table_name 
        //             FROM information_schema.columns 
        //             WHERE column_name = 'id' AND table_schema = 'public' AND data_type IN ('integer', 'bigint')
        //         )
        //         LOOP
        //             EXECUTE 'SELECT setval(pg_get_serial_sequence(''' || rec.table_name || ''', ''id''), (SELECT COALESCE(MAX(id)+1, 1) FROM ' || rec.table_name || '))';
        //         END LOOP;
        //     END;
        //     $$;
        // ";

        // DB::statement($query);

        $this->info('Sequences reset successfully.');
    }
}
