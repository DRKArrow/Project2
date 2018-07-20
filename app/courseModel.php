<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class courseModel extends Model {
	protected $table = 'tblcourses';
	public $timestamps = false;
	//
	static function getAll()
	{
		return DB::select('select * from tblcourses inner join tblmajors on tblcourses.major_id=tblmajors.major_id');
	}
	static function getById($id)
	{
		return DB::select('select * from tblcourses where course_id=? limit 1',[$id]);
	}
	static function insertCourse($obj)
	{
		DB::insert('insert into tblcourses(course_name,major_id) values(?,?)',[$obj->course_name,$obj->major_id]);
	}	
	static function deleteCourse($id)
	{
		DB::delete('delete from tblcourses where course_id=?',[$id]);
	}
	static function updateCourse($obj)
	{
		DB::update('update tblcourses set course_name=?,major_id=? where course_id=?',[$obj->course_name,$obj->major_id,$obj->course_id]);
	}
	static function getMajors()
	{
		return DB::select('select * from tblmajors');
	}
}
