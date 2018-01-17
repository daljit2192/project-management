<?php

use Database\TruncateTable;
use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;

class StatusesTableSeeder extends Seeder
{

	use DisableForeignKeys, TruncateTable;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->disableForeignKeys();

        //Add the master administrator, user id of 1
    	$statuses = [
    		[
    			'name'        => 'Pending',
    			'created_at'        => Carbon::now(),
    			'updated_at'        => Carbon::now(),
    		],
    		[
    			'name'        => 'In progress',
    			'created_at'        => Carbon::now(),
    			'updated_at'        => Carbon::now(),
    		],
    		[
    			'name'        => 'Done',
    			'created_at'        => Carbon::now(),
    			'updated_at'        => Carbon::now(),
    		],
    		[
    			'name'        => 'Testing',
    			'created_at'        => Carbon::now(),
    			'updated_at'        => Carbon::now(),
    		],
    		[
    			'name'        => 'Confirmed',
    			'created_at'        => Carbon::now(),
    			'updated_at'        => Carbon::now(),
    		],
    	];

    	DB::table('statuses')->insert($statuses);

    	$this->enableForeignKeys();
    }
}
