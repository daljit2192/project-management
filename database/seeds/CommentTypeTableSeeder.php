<?php

use Database\TruncateTable;
use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;

class CommentTypeTableSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    public function run()
    {
        $this->disableForeignKeys();
        // $this->truncate(config("comment_type"));
        $comments = [
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
        ];

        DB::table('comment_type')->insert($comments);
        $this->enableForeignKeys();

    }
}
