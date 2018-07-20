<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\majorModel;
use App\courseModel;
class majorController extends Controller
{
    //
    public function majorsList()
    {
    	$majors = majorModel::all();
        for($i = 0 ; $i < count($majors) ; $i++)
        {
            $courses = courseModel::where('major_id',$majors[$i]->major_id)->orderBy('course_name')->get();
            $courses_name = array();
            for($j = 0 ;$j < count($courses) ; $j++)
            {
                $courses_name[$j] = $courses[$j]->course_name;
            }
            $majors[$i]->course = $courses_name;
        }
    	return view('Admin.Major.majorsList',['majors' => $majors]);
    }
    public function addMajorProcess(Request $request)
    {
    	$obj = new majorModel();
    	$obj->major_name = $request->txtName;
        $count = majorModel::where('major_name',$request->txtName)->count();
        if($count == 0)
        {
            majorModel::insertMajor($obj);
             $notification = array(
                    'message' => trans('lang.success_insert_major'),
                    'alert-type' => 'success'
                );
         }else
         {
            $notification = array(
                    'message' => trans('lang.failed_insert_major'),
                    'alert-type' => 'error'
                );
         }
    	
 		return redirect()->route('majorsList')->with($notification);
    }
    public function deleteMajor($id)
    {
    	majorModel::deleteMajor($id);
    	$notification = array(
                'message' => trans('lang.success_delete_major'),
                'alert-type' => 'success'
            );
    	return redirect()->route('majorsList')->with($notification);
    }
    public function editMajor(Request $request)
    {
        $old_name = majorModel::where('major_id',$request->txtId)->first();
        $old_name = $old_name->major_name;    
        if($request->txtName !== $old_name)
        {
            $check = majorModel::where('major_name',$request->txtName)->count();
            if($check > 0)
            {
                $notification = array(
                    'message' => trans('lang.failed_edit_major'),
                    'alert-type' => 'error'
                );
            }else {
                 majorModel::where('major_id',$request->txtId)->update([
                    'major_name' => $request->txtName,
                ]);
                $notification = array(
                        'message' => trans('lang.success_edit_major'),
                        'alert-type' => 'success'
                    );
            }
        }else {
            $notification = array(
                        'message' => trans('lang.success_edit_major'),
                        'alert-type' => 'success'
                    );
        }
        return back()->with($notification);
    }
}
