<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class majorModel extends Model {
	protected $table = 'tblmajors';
	public $timestamps = false;
	//
	static function getAll()
	{
		return DB::select('select * from tblmajors');
	}
	static function getById($id)
	{
		return DB::select('select * from tblmajors where major_id=? limit 1',[$id]);
	}
	static function insertMajor($obj)
	{
		DB::insert('insert into tblmajors(major_name) values(?)',[$obj->major_name]);
	}	
	static function deleteMajor($id)
	{
		DB::delete('delete from tblmajors where major_id=?',[$id]);
	}
	static function updateMajor($obj)
	{
		DB::update('update tblmajors set major_name=? where major_id=?',[$obj->major_name,$obj->major_id]);
	}
}
