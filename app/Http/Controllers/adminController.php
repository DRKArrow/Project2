<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\adminModel;
use App\classModel;
use App\saleModel;
use App\studentModel;
use Session;
class adminController extends Controller
{
    //
    public function mainPage()
    {
        $classes = classModel::all();
        $students = studentModel::count();
        $sales = saleModel::all();
        return view('Admin.dashboard',['classes' => $classes,'sales' => $sales,'students' => $students]);
    }
    public function login()
    {
        if(session()->has('admin_email'))
        {
            return redirect()->route('Admindashboard');
        }
        return view('Admin.login');
    }
    public function loginProcess(Request $request)
    {
    	$obj = new adminModel();
    	$obj->admin_email = $request->txtEmail;
    	$obj->admin_pass = md5($request->txtPass);
    	$check = adminModel::checkRow($obj);
    	if($check > 0)
    	{
            $getName = adminModel::getById($obj->admin_email);
            $objName = $getName[0];
    		session()->put([
            'admin_email' => $obj->admin_email,
            'admin_name' => $objName->admin_name,
        ]);
    		return redirect()->route('Admindashboard');
    	}else
    	{
    		return redirect()->route('adminLogin')->with("err","Please, try again!");
    	}
    }
}
