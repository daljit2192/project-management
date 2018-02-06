<?php

use Database\TruncateTable;
use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Database\DisableForeignKeys;
use Illuminate\Support\Facades\DB;

class PriortyTableSeeder extends Seeder
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
    	$priorties = [
    		[
    			'name'        => 'High',
    			'created_at'        => Carbon::now(),
    			'updated_at'        => Carbon::now(),
    		],
    		[
    			'name'        => 'Medium',
    			'created_at'        => Carbon::now(),
    			'updated_at'        => Carbon::now(),
    		],
    		[
    			'name'        => 'Low',
    			'created_at'        => Carbon::now(),
    			'updated_at'        => Carbon::now(),
    		],
    		[
    			'name'        => 'None',
    			'created_at'        => Carbon::now(),
    			'updated_at'        => Carbon::now(),
    		],
    	];

    	DB::table('priorties')->insert($priorties);

    	$this->enableForeignKeys();
    }
}
