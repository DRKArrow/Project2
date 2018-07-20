<?php

use Illuminate\Database\Seeder;

class saleInsert extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('tblsales')->delete();
        
        DB::table('tblsales')->insert([
        	'sale_name' => 'Hoàng Việt',
        	'sale_email' => 'viet@gmail.com',
        	'sale_pass' => md5('123456'),
        	'sale_phone' => '021654654'
        ]);
    }
}
