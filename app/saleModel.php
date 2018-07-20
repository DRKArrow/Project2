<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class saleModel extends Model {
	protected $table = 'tblsales';
	public $timestamps = false;
	//
	static function getAll()
	{
		return DB::select('select * from tblsales');
	}
	static function getById($id)
	{
		return DB::select('select * from tblsales where sale_id=? limit 1',[$id]);
	}
	static function checkRow($obj)
    {
    	$arr=DB::select("select * from tblsales where sale_email=? and sale_pass=? ",[$obj->sale_email,$obj->sale_pass]);
    	$check = count($arr);
    	return $check;
    }
    static function getMajor()
    {
    	return DB::select('select * from tblmajors');
    }
    static function getCourse()
    {
    	return DB::select('select * from tblcourses');
    }
}
