<?php

use App\Models\ClubRate;
use App\Models\RateCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Rates that were shown on /mitgliedschaft before this migration.
     */
    private const PREVIOUS_ACTIVE_RATE_IDS = [1, 2, 3, 4, 9, 10, 11, 12];

    private const NEW_CATEGORIES = [
        ['position' => 1, 'name' => '6 Monate', 'duration' => 6, 'prices' => [79, 99, 139]],
        ['position' => 2, 'name' => '12 Monate', 'duration' => 12, 'prices' => [59, 79, 129]],
        ['position' => 3, 'name' => '1 Monat', 'duration' => 1, 'prices' => [99, 129, 159]],
    ];

    /**
     * Old rates are only deactivated: club_members cascade on delete, so
     * deleting a rate would also delete the memberships attached to it.
     */
    public function up(): void
    {
        DB::transaction(function () {
            ClubRate::where('status', true)->update(['status' => false]);

            foreach (self::NEW_CATEGORIES as $data) {
                $category = RateCategory::create([
                    'position' => $data['position'],
                    'name' => $data['name'],
                    'duration' => $data['duration'],
                ]);

                [$oneHour, $twoHours, $allCourses] = $data['prices'];

                $category->rates()->createMany([
                    ['name' => '1 Std.', 'amount' => $oneHour, 'limit' => 1, 'status' => true],
                    ['name' => '2 Std.', 'amount' => $twoHours, 'limit' => 2, 'status' => true],
                    ['name' => 'Alle Kurse', 'amount' => $allCourses, 'limit' => 0, 'status' => true],
                ]);
            }
        });
    }

    /**
     * New rates are kept but hidden, as members may already be attached to them.
     */
    public function down(): void
    {
        DB::transaction(function () {
            $categoryIds = RateCategory::whereIn('name', array_column(self::NEW_CATEGORIES, 'name'))->pluck('id');

            ClubRate::whereIn('rate_category_id', $categoryIds)->update(['status' => false]);
            ClubRate::whereIn('id', self::PREVIOUS_ACTIVE_RATE_IDS)->update(['status' => true]);
        });
    }
};
