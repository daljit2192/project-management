<?php

use Database\TruncateTable;
use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;

class NotificationTypeTableSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    public function run()
    {
        $this->disableForeignKeys();
        $notifications = [
            [
                'name' => 'tasks',
                'created_by' => 1,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'name' => 'projects',
                'created_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'comments',
                'created_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('notification_type')->insert($notifications);
        $this->enableForeignKeys();

    }
}
