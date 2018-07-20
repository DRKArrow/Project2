<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class classModel extends Model {
	protected $table = 'tblclasses';
	public $timestamps = false;
	//
	static function getAll()
	{
		return DB::select('select * from tblclasses');
	}
	static function getById($id)
	{
		return DB::select('select * from tblclasses where class_id=? limit 1',[$id]);
	}
	static function insertClass($obj)
	{
		DB::insert('insert into tblclasses(class_name,class_startdate,course_id,class_id) values(?,?,?,?)',[$obj->class_name,$obj->class_startdate,$obj->course_id,$obj->class_id]);
	}	
	static function deleteClass($id)
	{
		DB::delete('delete from tblclasses where class_id=?',[$id]);
	}
	static function updateClass($obj)
	{
		DB::update('update tblclasses set class_name=?,class_startdate=?,course_id=?,schedule_id=? where class_id=?',[$obj->class_name,$obj->class_startdate,$obj->course_id,$obj->class_id,$obj->class_id]);
	}

}
