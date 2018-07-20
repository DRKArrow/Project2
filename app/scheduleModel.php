<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class scheduleModel extends Model {
	protected $table = 'tblschedules';
	public $timestamps = false;
	//
	static function getAll()
	{
		return DB::select('select * from tblschedules');
	}
	static function getById($id)
	{
		return DB::select('select * from tblschedules where schedule_id=? limit 1',[$id]);
	}
	static function insertSchedule($obj)
	{
		DB::insert('insert into tblschedules(schedule_name,schedule_start,schedule_end) values(?,?,?)',[$obj->schedule_name,$obj->schedule_start,$obj->schedule_end]);
	}	
	static function deleteSchedule($id)
	{
		DB::delete('delete from tblschedules where schedule_id=?',[$id]);
	}
	static function updateSchedule($obj)
	{
		DB::update('update tblschedules set schedule_name=?,schedule_start=?,schedule_end=? where schedule_id=?',[$obj->schedule_name,$obj->schedule_start,$obj->schedule_end,$obj->schedule_id]);
	}
}
