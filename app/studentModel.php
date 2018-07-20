<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class studentModel extends Model {
	protected $table = 'tblstudents';
	//
	static function getAll()
	{
		return DB::select('select * from tblstudents');
	}
	static function getById($id)
	{
		return DB::select('select * from tblstudents where student_id=? limit 1',[$id]);
	}
	static function insertStudent($obj)
	{
		DB::insert('insert into tblstudents(student_name,student_dob,student_phone,student_address,course_id) values(?,?,?,?,?)',[$obj->student_name,$obj->student_dob,$obj->student_phone,$obj->student_address,$obj->course_id]);
	}
	static function deleteStudent($id)
	{
		DB::delete('delete from tblstudents where student_id=?',[$id]);
	}
	static function updateStudent($obj)
	{
		DB::update('update tblstudents set student_name=?,student_dob=?,student_phone=?,student_address=?,course_id where student_id=?',[$obj->student_name,$obj->student_dob,$obj->student_phone,$obj->student_address,$obj->course_id,$obj->student_id]);
	}
}
