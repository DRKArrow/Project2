<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\classModel;
use App\courseModel;
use App\scheduleModel;
class courseController extends Controller
{
    //
    public function coursesList()
    {
    	$courses = courseModel::join('tblmajors','tblcourses.major_id','=','tblmajors.major_id')->get();
        $majors = courseModel::getMajors();
        for($i = 0 ; $i < count($courses) ; $i++)
        {
            $classes = classModel::where('course_id',$courses[$i]->course_id)->orderBy('class_name')->get();
            $classes_name = array();
            for($j = 0 ;$j < count($classes) ; $j++)
            {
                $classes_name[$j] = $classes[$j]->class_name;
            }
            $courses[$i]->class = $classes_name;
        }
    	return view('Admin.Course.coursesList',['courses' => $courses,'majors' => $majors]);
    }
    public function addCourseProcess(Request $request)
    {
        $count = courseModel::where('course_name',$request->txtName)->where('major_id',$request->ddlMajor)->count();
        if($count == 0)
        {
            courseModel::insert([
                'course_name' => $request->txtName,
                'major_id' => $request->ddlMajor,
            ]);
            $notification = array(
                    'message' => trans('lang.success_insert_course'),
                    'alert-type' => 'success'
                );
        }else
    	{
            $notification = array(
                    'message' => trans('lang.failed_insert_course'),
                    'alert-type' => 'error'
                );
        }
 		return redirect()->route('coursesList')->with($notification);
    }
    public function deleteCourse($id)
    {
    	courseModel::deleteCourse($id);
    	$notification = array(
                'message' => trans('lang.success_delete_course'),
                'alert-type' => 'success'
            );
    	return redirect()->route('coursesList')->with($notification);
    }
    public function editCourse(Request $request)
    {
        $old_name = courseModel::where('course_id',$request->txtId)->first();
        $old_name = $old_name->course_name;
        if($request->txtName !== $old_name)
        {
            $check = courseModel::where('course_name',$request->txtName)->count();
            if($check > 0 )
            {
                $notification = array(
                    'message' => trans('lang.failed_edit_course'),
                    'alert-type' => 'error'
                );
            }else {
                $classes = classModel::where('class_name','like',$old_name . ' %')->get();
                courseModel::where('course_id',$request->txtId)->update([
                    'course_name' => $request->txtName,
                    'major_id' => $request->ddlMajor,
                ]);
                for($i = 0 ; $i < count($classes) ; $i++)
                {    
                    $new_name = courseModel::where('course_id',$classes[$i]->course_id)->first();
                    $new_name = $new_name->course_name;
                    $schedule = scheduleModel::where('schedule_id',$classes[$i]->schedule_id)->first();
                    classModel::where('class_id',$classes[$i]->class_id)->update([
                        'class_name' => $new_name . ' ' . $schedule->schedule_name,
                    ]);
                }
                $notification = array(
                    'message' => trans('lang.success_edit_course'),
                    'alert-type' => 'success'
                );
            }
        }else {
            courseModel::where('course_id',$request->txtId)->update([
                    'major_id' => $request->ddlMajor,
                ]); 
            $notification = array(
                    'message' => trans('lang.success_edit_course'),
                    'alert-type' => 'success'
                );
        }
        
        return back()->with($notification);
    }
}
