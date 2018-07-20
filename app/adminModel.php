<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class adminModel extends Model {
	protected $table = 'tbladmins';
	//
	static function getAll()
	{
		return DB::select('select * from tbladmins');
	}
	static function getById($id)
	{
		return DB::select('select * from tbladmins where admin_email=? limit 1',[$id]);
	}
	static function insertAdmin($obj)
	{
		DB::insert('insert into tbladmins values(?,?,?)',[$obj->admin_name,$obj->admin_email,$obj->admin_pass]);
	}
	static function deleteAdmin($id)
	{
		DB::delete('delete from tbladmins where admin_email=?',[$id]);
	}
	static function updateAdmin($obj)
	{
		DB::update('update tbladmins set admin_pass=? where admin_email=?',[$obj->admin_name,$obj->admin_pass,$obj->admin_email]);
	}
	static function checkRow($obj)
    {
    	$arr=DB::select("select * from tbladmins where admin_email=? and admin_pass=? ",[$obj->admin_email,$obj->admin_pass]);
    	$check = count($arr);
    	return $check;
    }
}
