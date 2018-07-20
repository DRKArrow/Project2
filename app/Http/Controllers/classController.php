<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\classModel;
use App\majorModel;
use App\courseModel;
use App\scheduleModel;
use App\class_detailModel;
use App\studentModel;
use App\interestModel;
use Mail;
class classController extends Controller
{
    //
    public function classesList()
    {
    	$classes = classModel::all();
        for($i=0 ; $i<count($classes) ; $i++)
        {
            $count = class_detailModel::where('class_id',$classes[$i]->class_id)->count();
            $classes[$i]->count = $count;
        }
    	$majors = majorModel::all();
    	return view('Admin.Class.classesList',['classes' => $classes,'majors' => $majors]);
    }
    public function addClassProcess(Request $request)
    {
    	$course = $request->ddlCourse;
    	$schedule = $request->ddlSchedule;
    	$courses = courseModel::getById($course);
  		$course_name = $courses[0]->course_name;
  		$schedules = scheduleModel::getById($schedule);
  		$schedule_name = $schedules[0]->schedule_name;
  		$name = $course_name . ' ' . $schedule_name;
        $count = classModel::where('class_name',$name)->count();
        if($count == 0)
        {
            classModel::insert([
                'class_name' => $name,
                'class_startdate' => date("Y-m-d"),
                'course_id' => $course,
                'schedule_id' => $schedule,
            ]);
            //----------------------
            $interest = $course . '|' . $schedule;
            $interests = interestModel::where('interest',$interest)->count();
            if($interests > 0)
            {
                $class_id = classModel::where('class_name',$name)->first();
                $class_id = $class_id->class_id;
                $students = interestModel::where('interest',$interest)->get();
                $students_id = array();
                for($i = 0 ; $i < count($students) ; $i++)
                {
                    $students_id[$i] = $students[$i]->student_id;
                    interestModel::where('student_id',$students_id[$i])->where('interest','like', $course . '|%')->delete();
                    interestModel::where('student_id',$students_id[$i])->where('interest','like', '%|' . $schedule)->delete();
                    class_detailModel::insert([
                        'class_id' => $class_id,
                        'student_id' => $students_id[$i]
                    ]);
                }
            }
        	
            $notification = array(
                'message' => trans('lang.success_insert_class'),
                'alert-type' => 'success'
            );
        }else{
            $notification = array(
                'message' => trans('lang.failed_insert_class'),
                'alert-type' => 'error'
            );
        }
        return back()->with($notification);
    }
    public function OpenClass($id)
    {
        $students = studentModel::join('tblclass_detail','tblstudents.student_id','=','tblclass_detail.student_id')->where('class_id',$id)->get();
        $class = classModel::where('class_id',$id)->first();
        $data = ['class' => $class->class_name,'date' => date('d-m-Y',strtotime($class->class_startdate)),'students' => $students];
        $email = studentModel::join('tblclass_detail','tblclass_detail.student_id','=','tblstudents.student_id')->where('class_id',$id)->select('student_email')->get();
        $emails = array();
        for($i = 0 ; $i < count($email) ; $i++)
        {
            $emails[$i] = $email[$i]->student_email;
        }
        Mail::send('emails.mail',$data,function($msg) use ($emails, $class) {
            $msg->from('bkacad.vn@gmail.com','Administrator');
            $msg->to($emails)->subject('Khai giảng lớp học ' . $class->class_name . ' của BKACAD!');
        });
        classModel::where('class_id',$id)->update([
            'check' => 1,
        ]);
        $notification = array(
            'message' => trans('lang.success_open_class'),
            'alert-type' => 'success'
        );
        return redirect()->route('classesList')->with($notification);
    }
    public function deleteClass($id)
    {
        classModel::where('class_id',$id)->delete();
        $notification = array(
                'message' => trans('lang.success_delete_class'),
                'alert-type' => 'success'
            );
        return redirect()->route('classesList')->with($notification);
    }
    public function classDetail($id)
    {
        $class = classModel::where('class_id',$id)->first();
        $students = studentModel::join('tblclass_detail','tblstudents.student_id','=','tblclass_detail.student_id')->where('class_id',$id)->get();
        return view('Admin.Class.classDetail',['class' => $class,'students' => $students]);
    }
}
