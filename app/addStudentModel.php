<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class addStudentModel extends Model {

	//
	static function getAll()
	{
		return DB::select('select * from tbladdstudents');
	}
	static function getByScheduleId($id)
	{
		return DB::select('select * from tbladdstudents where schedule_id=?',[$id]);
	}
	static function getByStudentId($id)
	{
		return DB::select('select * from tbladdstudents where student_id=?',[$id]);
	}
	static function insertAdd($obj)
	{
		DB::insert('insert into tbladdstudents values(?,?)',[$obj->schedule_id,$obj->student_id]);
	}
	static function deleteAdd($schedule_id,$student_id)
	{
		DB::delete('delete from tbladdstudents where schedule_id=? and student_id=?',[$schedule_id,$student_id]);
	}
	static function updateAdd($obj)
	{
		DB::update('update tbladdstudents set schedule_id=?,student_id=? where schedule_id=? and student_id=?',[$obj->schedule_id,$obj->student_id,$obj->schedule_id,$obj->student_id]);
	}
}
