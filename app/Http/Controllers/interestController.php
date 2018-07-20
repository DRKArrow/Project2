<?php

namespace App\Http\Controllers;
use App\interestModel;
use App\courseModel;
use App\scheduleModel;
use App\classModel;
use App\class_detailModel;
use App\studentModel;
use Illuminate\Http\Request;

class interestController extends Controller
{
    //
    public function interestsList()
    {
    	$interests = interestModel::select('interest')->distinct()->get();
    	for($i = 0; $i < count($interests) ; $i++)
    	{
    		$count = interestModel::where('interest',$interests[$i]->interest)->count();
    		$interest = $interests[$i]->interest;
    		$interest = explode('|',$interest);
    		$course_id = $interest[0];
    		$schedule_id = $interest[1];
    		$course_name = courseModel::where('course_id',$course_id)->first();
    		$schedule_name = scheduleModel::where('schedule_id',$schedule_id)->first();
    		$class_name = $course_name->course_name . ' ' . $schedule_name->schedule_name;
    		$interests[$i]->count = $count;
    		$interests[$i]->class_name = $class_name;
    	}
    	return view('Admin.Interest.interestsList',['interests' => $interests]);
    }
    public function addClass($id)
    {
        $id_explode = explode('|',$id);
        $course_id = $id_explode[0];
        $schedule_id = $id_explode[1];
        $course_name = courseModel::where('course_id',$course_id)->first();
        $course_name = $course_name->course_name;
        $schedule_name = scheduleModel::where('schedule_id',$schedule_id)->first();
        $schedule_name = $schedule_name->schedule_name;
        $class_name = $course_name . ' ' . $schedule_name;
        classModel::insert([
            'class_name' => $class_name,
            'class_startdate' => date("Y-m-d"),
            'course_id' => $course_id,
            'schedule_id' => $schedule_id
        ]);
        $class_id = classModel::where('class_name',$class_name)->first();
        $class_id = $class_id->class_id;
        $students = interestModel::where('interest',$id)->get();
        $students_id = array();
        for($i = 0 ; $i < count($students) ; $i++)
        {
            $students_id[$i] = $students[$i]->student_id;
            interestModel::where('student_id',$students_id[$i])->where('interest','like', $course_id . '|%')->delete();
            interestModel::where('student_id',$students_id[$i])->where('interest','like', '%|' . $schedule_id)->delete();
            class_detailModel::insert([
                'class_id' => $class_id,
                'student_id' => $students_id[$i]
            ]);
        }
        $notification = array(
                'message' => trans('lang.success_insert_class'),
                'alert-type' => 'success'
        );
        return back()->with($notification);
    }
    public function interestDetail($id)
    {
        $students = studentModel::join('tblinterest','tblstudents.student_id','=','tblinterest.student_id')->where('interest',$id)->get();
        $interest = interestModel::where('interest',$id)->first();
        $interest_ex = $interest->interest;
        $interest_ex = explode('|',$interest_ex);
        $course_id = $interest_ex[0];
        $schedule_id = $interest_ex[1];
        $course_name = courseModel::where('course_id',$course_id)->first();
        $schedule_name = scheduleModel::where('schedule_id',$schedule_id)->first();
        $class_name = $course_name->course_name . ' ' . $schedule_name->schedule_name;
        $interest->class_name = $class_name;
        return view('Admin.Interest.interestDetail',['students' => $students,'interest' => $interest]);
    }
}
