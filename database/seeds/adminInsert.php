<?php

use Illuminate\Database\Seeder;

class adminInsert extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('tbladmins')->delete();
        
        DB::table('tbladmins')->insert([
        	'admin_name' => 'Arrow',
        	'admin_email' => 'mightyarrow255@gmail.com',
        	'admin_pass' => md5('dungzin1102')
        ]);
    }
}
