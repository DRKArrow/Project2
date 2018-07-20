<?php

namespace App\Http\Controllers;
use App\courseModel;
use App\scheduleModel;
use App\majorModel;
use App\classModel;
use App\class_detailModel;
use App\studentModel;
use App\interestModel;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    //
    public function getCourses(Request $request)
    {
        $data = courseModel::select('course_id','course_name')->where('major_id',$request->id)->get();
        return response()->json($data);
    }
    public function getSchedules(Request $request)
    {
        $data = scheduleModel::select('schedule_id','schedule_name','schedule_start','schedule_end')->get();
        return response()->json($data);
    }
    public function getCourses_classList(Request $request)
    {
        $data = courseModel::select('course_id','course_name')->where('major_id',$request->id)->get();
        for($i=0 ; $i < count($data) ; $i++)
        {
            $count = classModel::where('course_id',$data[$i]->course_id)->count();
            $data[$i]->count = $count;
        }
        return response()->json($data);
    }
    public function getStudent(Request $request)
    {
        $data = class_detailModel::join('tblstudents','tblclass_detail.student_id','=','tblstudents.student_id')->join('tblsales','tblstudents.sale_id','=','tblsales.sale_id')->where('class_id',$request->id)->get();
        return response()->json($data);
    }
    public function getStudentName(Request $request)
    {
        $data = studentModel::where('student_id',$request->id)->first();
        return response()->json($data);
    }
    public function SaleStat(Request $request)
    {
        $datas = studentModel::where('sale_id',$request->id)->get();
        $data = count($datas);
        return response()->json($data);
    }
    public function ViewStats(Request $request)
    {
        $data = classModel::where('check',1)->whereMonth('class_startdate',$request->m)->whereYear('class_startdate',$request->y)->get();
        for($i=0 ; $i < count($data) ; $i++)
        {
            $class_id = $data[$i]->class_id;
            $count = class_detailModel::where('class_id',$class_id)->groupBy('class_id')->count();
            $data[$i]->count = $count;
        }
        return response()->json($data);
    }
    // public function Notification(Request $request)
    // {
    //     $data = classModel::where('check',1)->whereBetween('class_startdate',[$request->owe,$request->td])->get();
    //     return response()->json($data);
    // }
    // public function Notification2(Request $request)
    // {
    //     $data = interestModel::select('interest')->distinct()->get();
    //     $data = count($data);
    //     return response()->json($data);
    // }
    public function getMajor(Request $request)
    {
        $data = majorModel::join('tblcourses','tblmajors.major_id','=','tblcourses.major_id')->where('course_id',$request->course_id)->first();
        return response()->json($data);
    }
    public function CheckStudent(Request $request)
    {
        $data = array();
        $count = class_detailModel::where('class_id',$request->class_id)->where('student_id',$request->student_id)->count();
        $check_class = classModel::select('schedule_id')->where('class_id',$request->class_id)->first();
        $check_student = class_detailModel::join('tblclasses','tblclass_detail.class_id','=','tblclasses.class_id')->where('student_id',$request->student_id)->select('schedule_id')->get();
        $class_schedule = classModel::join('tblschedules','tblclasses.schedule_id','=','tblschedules.schedule_id')->where('tblclasses.schedule_id',$check_class->schedule_id)->select('schedule_name')->first();
        $class_schedule = $class_schedule->schedule_name;
        // $class_schedule = $class_schedule[0];
        // //---------------
        // $class_schedule = explode(',',$class_schedule);
        //-------------
        $student_schedule = array();
        for($i = 0 ; $i < count($check_student); $i++)
        {
            $student_schedule[$i] = classModel::join('tblschedules','tblclasses.schedule_id','=','tblschedules.schedule_id')->where('tblclasses.schedule_id',$check_student[$i]->schedule_id)->select('schedule_name')->first();
            $student_schedule[$i] = $student_schedule[$i]->schedule_name;
            // $student_schedule[$i] = $student_schedule[$i][0];
            // $student_schedule[$i] = explode(',',$student_schedule[$i]);
        }
        $check = 0;
        for($i = 0; $i < count($student_schedule) ; $i++)
        {
            if($class_schedule == $student_schedule[$i])
            {
                $check++;
            }
        }
        //-----------------------------
        $schedule_time = classModel::join('tblschedules','tblclasses.schedule_id','=','tblschedules.schedule_id')->where('tblclasses.schedule_id',$check_class->schedule_id)->select('schedule_name')->first();
        $schedule_time = $schedule_time->schedule_name;
        $schedule_time = explode('(',$schedule_time);
        $schedule_time = explode(')',$schedule_time[1]);
        $schedule_time = $schedule_time[0];
        //-----------------------
        $student_time = array();
        for($i = 0 ; $i < count($check_student); $i++)
        {
            $student_time[$i] = classModel::join('tblschedules','tblclasses.schedule_id','=','tblschedules.schedule_id')->where('tblclasses.schedule_id',$check_student[$i]->schedule_id)->select('schedule_name')->first();
            $student_time[$i] = explode('(',$student_time[$i]->schedule_name);
            $student_time[$i] = explode(')',$student_time[$i][1]);
            $student_time[$i] = $student_time[$i][0];
        }
        //-------------------------
        $checkTime = 0;
        for($i = 0 ; $i < count($student_time) ; $i++)
        {
            if($schedule_time == $student_time[$i])
            {
                $checkTime++;
            }
        }
        $data['count'] = $count;
        $data['checkTime'] = $checkTime;
        $data['check'] = $check;
        return response()->json($data);
    }
    public function CheckClass(Request $request)
    {
        $data = class_detailModel::where('class_id',$request->id)->count();
        return response()->json($data);
    }
    public function CheckStudentSale(Request $request)
    {
        $data = studentModel::join('tblclass_detail','tblstudents.student_id','=','tblclass_detail.student_id')->where('tblstudents.student_id',$request->id)->count();
        return response()->json($data);
    }
    public function CheckOpenClass(Request $request)
    {
        $data = class_detailModel::where('class_id',$request->id)->count();
        return response()->json($data);
    }
    public function getCourseInterest(Request $request)
    {
        $data = studentModel::where('student_id',$request->id)->first();
        // $classes = class_detailModel::join('tblstudents','tblclass_detail.student_id','=','tblstudents.student_id')->join('tblclasses','tblclass_detail.class_id','=','tblclasses.class_id')->where('tblstudents.student_id',$request->id)->select('class_name')->get();
        // // -----------------
        // $classes_name = array();
        // for($i = 0 ; $i < count($classes) ; $i++)
        // {
        //     $mid = explode(' ',$classes[$i]->class_name);
        //     $classes_name[$i] = $mid[0];
        // }
        // // --------------------------------
        // $interests = interestModel::join('tblstudents','tblinterest.student_id','=','tblstudents.student_id')->where('tblstudents.student_id',$request->id)->select('interest')->get();
        // $course_interest = array();
        // $schedule_interest = array();
        // $class_interest = array();
        // for($i = 0 ; $i < count($interests) ; $i++)
        // {
        //     $interest = explode('|',$interests[$i]->interest);
        //     $course_interest[$i] = $interest[0];
        //     $schedule_interest[$i] = $interest[1];
        //     $course_interest[$i] = courseModel::where('course_id',$course_interest[$i])->select('course_name')->first();
        //     $schedule_interest[$i] = scheduleModel::where('schedule_id',$schedule_interest[$i])->select('schedule_name')->first();
        //     $class_interest[$i] = $course_interest[$i]->course_name . ' ' . $schedule_interest[$i]->schedule_name;
        //  }
        // // ----------------------
        // // $data['class'] = implode(', ',$classes_name);
        // $data['class'] = $classes_name;
        // $data['interest'] = implode(', ',$class_interest);
        return response()->json($data);
    }
    public function CheckInterest(Request $request)
    {
        $classes = class_detailModel::where('student_id',$request->student_id)->get();
        $course = array();
        for($i = 0; $i < count($classes) ; $i++)
        {
            $course[$i] = classModel::where('class_id',$classes[$i]->class_id)->select('course_id')->first();
        }
        $count = 0;
        for($i = 0; $i< count($course) ; $i++)
        {
            if($course[$i]->course_id == $request->course_id) $count++;
        }
        //-----------------------------------------------------
        $check_student = class_detailModel::join('tblclasses','tblclass_detail.class_id','=','tblclasses.class_id')->where('student_id',$request->student_id)->select('schedule_id')->get();
        $schedule_name = scheduleModel::where('schedule_id',$request->schedule_id)->first();
        $schedule_name = $schedule_name->schedule_name;
        // $schedule_name = explode(' ',$schedule_name);
        // $schedule_name = explode(',',$schedule_name[0]);
        //-------------
        $student_schedule = array();
        for($i = 0 ; $i < count($check_student); $i++)
        {
            $student_schedule[$i] = classModel::join('tblschedules','tblclasses.schedule_id','=','tblschedules.schedule_id')->where('tblclasses.schedule_id',$check_student[$i]->schedule_id)->select('schedule_name')->first();
            $student_schedule[$i] = $student_schedule[$i]->schedule_name;
            // $student_schedule[$i] = explode(' ',$student_schedule[$i]->schedule_name);
            // $student_schedule[$i] = $student_schedule[$i][0];
            // $student_schedule[$i] = explode(',',$student_schedule[$i]);
        }
        $check = 0;
        for($i = 0; $i < count($student_schedule) ; $i++)
        {
            if($schedule_name == $student_schedule[$i])
            {
                $check++;
            }
        }
        //---------------------
        $schedule_time = scheduleModel::where('schedule_id',$request->schedule_id)->first();
        $schedule_time = $schedule_time->schedule_name;
        $schedule_time = explode('(',$schedule_time);
        $schedule_time = explode(')',$schedule_time[1]);
        $schedule_time = $schedule_time[0];
        //------------------------------
        $student_time = array();
        for($i = 0 ; $i < count($check_student); $i++)
        {
            $student_time[$i] = classModel::join('tblschedules','tblclasses.schedule_id','=','tblschedules.schedule_id')->where('tblclasses.schedule_id',$check_student[$i]->schedule_id)->select('schedule_name')->first();
            $student_time[$i] = explode('(',$student_time[$i]->schedule_name);
            $student_time[$i] = explode(')',$student_time[$i][1]);
            $student_time[$i] = $student_time[$i][0];
        }
        $checkTime = 0;
        for($i = 0; $i < count($student_time) ; $i++)
        {
            if($schedule_time == $student_time[$i])
            {
                $checkTime++;
            }
        }
        //--------------------
        $checkInterest = 0;
        $interests = interestModel::where('student_id',$request->student_id)->get();
        for($i = 0 ; $i < count($interests) ; $i++)
        {
            if($interests[$i]->interest == ($request->course_id . '|' . $request->schedule_id)) $checkInterest++;
        }
        $data['count'] = $count;
        $data['check'] = $check;
        $data['checkTime'] = $checkTime;
        $data['checkInterest'] = $checkInterest;
        return response()->json($data);
    }
    public function CheckDeleteCourse(Request $request)
    {
        $data = classModel::where('course_id',$request->id)->count();
        return response()->json($data);
    }
    public function CheckDeleteMajor(Request $request)
    {
        $data = courseModel::where('major_id',$request->id)->count();
        return response()->json($data);
    }
    public function SearchCourse(Request $request)
    {
        $output = '';
        $courses = courseModel::where('course_name','like','%' . $request->key . '%')->get();
        for($i = 0 ; $i < count($courses) ; $i++)
        {
            $open = classModel::where('course_id',$courses[$i]->course_id)->where('check',1)->count();
            $all = classModel::where('course_id',$courses[$i]->course_id)->count();
            $courses[$i]->all = $all;
            $courses[$i]->open = $open;
        }
        if(count($courses) > 0)
        {
            $output .= '<div class="row">';
            foreach($courses as $course)
            {
                $output .= '<div class="col s12 m6 l6">';
                $output .= '<div class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text"><div class="padding-4"><div class="col s7 m7"><i class="material-icons background-round mt">layers</i><p>';
                $output .= $course->course_name;
                $output .= '</p></div><div class="col s5 m5 right-align"><h5 class="mb-0">';
                $output .=  $course->open;
                $output .= '</h5><p class="no-margin">';
                $output .= trans('lang2.db_classopen');
                $output .= '</p><h4 class="mb-4"><a href="';
                $output .= route('classList',['id' => $course->major_id,'id2' => $course->course_id]);
                $output .= '" class="white-text text-darken-1 btn waves-effect waves-light gradient-45deg-amber-amber btn-large gradient-shadow">';
                $output .= $course->all;
                $output .= ' ';
                $output .= trans('lang2.db_classes2');
                $output .= '</a></h4>
                                    </div>
                                  </div>
                                </div>
                              </div>';
            }
            $output .= '</div>';
            echo $output;
        }else {
            $output .= '<div class="row center-align">';
            $output .= '<img src="';
            $output .= asset('images/nodata.gif');
            $output .= '">';
            $output .= '</div>';
            echo $output;
        }
    }
    public function SearchClass(Request $request)
    {
        $output = '';
        $classes = classModel::where('class_name','like','%' . $request->key . '%')->get();
        for($i = 0 ; $i < count($classes) ; $i++){
            $student = class_detailModel::where('class_id',$classes[$i]->class_id)->count();
            $classes[$i]->student = $student;
        }
        if(count($classes) > 0)
        {
            $course_id = $classes[0]->course_id;
            $id = majorModel::join('tblcourses','tblmajors.major_id','=','tblcourses.major_id')->where('course_id',$course_id)->first();
            $id = $id->major_id;
            $output .= '<div class="row">';
            foreach($classes as $class)
            {
                $output .= '<div class="col s12 m6 l6">';
                $output .= '<div class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-200 white-text"><div class="padding-4"><div class="col s7 m7"><i class="material-icons background-round mt">layers</i><p>';
                $output .= $class->class_name;
                $output .= '</p></div><div class="col s5 m5 right-align"><h6 class="">';
                $output .=  $class->student;
                $output .= ' ';
                $output .= trans('lang2.db_student4');
                $output .= '</h6>';
                $output .= '<h5 class="no-margin"><a href="';
                $output .= route('class_detail',['id' => $id,'id2' => $class->class_id]);
                $output .= '" class="white-text text-darken-1 btn waves-effect waves-light gradient-45deg-amber-amber btn-large gradient-shadow">';
                $output .= trans('lang2.class_see_detail');
                $output .= '</a></h5>';
                $output .= '<h5 class="margin-5">';
                if($class->check == 1) $output .= trans('lang2.class_opened');
                $output .= '</h5>';
                $output .= '
                                    </div>
                                  </div>
                                </div>
                              </div>';
            }
            $output .= '</div>';
            echo $output;
        }
    }
}
