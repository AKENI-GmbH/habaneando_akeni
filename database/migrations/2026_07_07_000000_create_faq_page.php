<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $existingPage = DB::table('pages')->where('identifier', 'faq')->first();

        if (! $existingPage) {
            $pageId = DB::table('pages')->insertGetId([
                'identifier' => 'faq',
                'name' => 'FAQ',
                'slug' => 'faq',
                'body' => '<p>Hier findest du bald Antworten auf häufige Fragen.</p>',
                'status' => true,
                'canDelete' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $pageId = $existingPage->id;
        }

        $hasHeader = DB::table('headers')
            ->where('headerable_type', 'App\Models\Page')
            ->where('headerable_id', $pageId)
            ->exists();

        if (! $hasHeader) {
            DB::table('headers')->insert([
                'mediaType' => 'image',
                'caption' => true,
                'overlay' => true,
                'overlayColor' => '#b51a00',
                'textColor' => '#ffffff',
                'overlayOpacity' => '100',
                'headerable_type' => 'App\Models\Page',
                'headerable_id' => $pageId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        $page = DB::table('pages')->where('identifier', 'faq')->first();

        if (! $page) {
            return;
        }

        DB::table('headers')
            ->where('headerable_type', 'App\Models\Page')
            ->where('headerable_id', $page->id)
            ->delete();

        DB::table('pages')->where('id', $page->id)->delete();
    }
};
