<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(adminInsert::class);
        $this->call(saleInsert::class);
        $this->call(insertSeed::class);
    }
}
