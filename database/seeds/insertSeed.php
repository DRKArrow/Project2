<?php

use Illuminate\Database\Seeder;

class insertSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('tblmajors')->insert([
            [
            	'major_name' => 'Programming',
            ],
            [
                'major_name' => 'Networking',
            ]
        ]);
        DB::table('tblcourses')->insert([
            [
            	'course_name' => 'PHP',
            	'major_id' => '1',
            ],
            [
                'course_name' => 'Joomla',
                'major_id' => '1',
            ],
            [
                'course_name' => 'Database',
                'major_id' => '1',
            ],
            [
                'course_name' => 'Security',
                'major_id' => '2',
            ]
        ]);
        DB::table('tblschedules')->insert([
            [
                'schedule_name' => '2,4,6 (08:00 AM - 10:00 AM)',
                'schedule_start' => '08:00:00',
                'schedule_end' => '10:00:00',
            ],
            [
                'schedule_name' => '2,4,6 (10:00 AM - 12:00 PM)',
                'schedule_start' => '10:00:00',
                'schedule_end' => '12:00:00',
            ],
            [
                'schedule_name' => '3,5,7 (08:00 AM - 10:00 AM)',
                'schedule_start' => '08:00:00',
                'schedule_end' => '10:00:00',
            ],
            [
                'schedule_name' => '3,5,7 (10:00 AM - 12:00 PM)',
                'schedule_start' => '10:00:00',
                'schedule_end' => '12:00:00',
            ]
        ]);
        DB::table('tblclasses')->insert([
            [
                'class_name' => 'PHP 2,4,6 (08:00 AM - 10:00 AM)',
                'class_startdate' => date('Y-m-d'),
                'course_id' => '1',
                'schedule_id' => '1'
            ]
        ]);
    }
}
