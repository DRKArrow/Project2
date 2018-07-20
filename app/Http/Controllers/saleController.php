<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\saleModel;
use App\classModel;
use App\courseModel;
use App\majorModel;
use App\studentModel;
use App\class_detailModel;
use App\interestModel;
use File;
use Image;
class saleController extends Controller
{
    //Sale Controller for Admin use
    public function salesList()
    {
    	$sales = saleModel::getAll();
        for($i = 0 ; $i < count($sales) ; $i++)
        {
            $students = studentModel::where('sale_id',$sales[$i]->sale_id)->count();
            $sales[$i]->students = $students;
        }
    	return view('Admin.Sale.salesListtest',['sales' => $sales]);
    }
    public function addSaleProcess(Request $request)
    {
        $count = saleModel::where('sale_email',$request->txtEmail)->count();
        if($count == 0)
        {
            $filename = 'user.png';
            if($request->hasFile('avatar'))
            {
                $avatar = $request->file('avatar');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(300,300)->save( public_path('/images/' . $filename) );
            }
            saleModel::insert([
                'sale_name' => $request->txtFirstName . ' ' . $request->txtLastName,
                'sale_email' => $request->txtEmail,
                'sale_pass' => md5($request->txtPass),
                'sale_phone' => $request->txtPhone,
                'sale_avatar' => 'images/' . $filename,
            ]);
            $notification = array(
                    'message' => trans('lang.success_insert_sale'),
                    'alert-type' => 'success'
                );
            return redirect()->route('salesList')->with($notification);
        }else {
           $notification = array(
                    'message' => trans('lang.failed_insert_sale'),
                    'alert-type' => 'error'
                ); 
           return back()->with($notification);
        }
    }
    
    //Sale Controller for Sale use
    public function dashboard()
    {
        $all = classModel::count();
        $open = classModel::where('check',1)->count();
        $student_all = studentModel::count();
        $student_by = studentModel::where('sale_id',session()->get('sale_id'))->count();
        return view('Sale.dashboard',['all' => $all,'open' => $open,'student_all' => $student_all,'student_by' => $student_by]);
    }
    public function login()
    {
        if(session()->has('sale_email'))
        {
            //
            return redirect()->route('dashboard');
        }
        return view('Sale.login');
    }
    public function loginProcess(Request $request)
    {
        $obj = new saleModel();
        $obj->sale_email = $request->txtEmail;
        $obj->sale_pass = md5($request->txtPass);
        $check = saleModel::checkRow($obj);
        if($check > 0)
        {
            $sale = saleModel::where('sale_email','=',$obj->sale_email)->first();
            session()->put([
            'sale_id' => $sale->sale_id,
            'sale_email' => $sale->sale_email,
            'sale_name' => $sale->sale_name,
        ]);
        $notification = array(
                'message' => 'Welcome to Sale Dashboard!',
                'alert-type' => 'success'
            );
           return redirect()->route('dashboard')->with($notification);
        }else
        {
            return redirect()->route('saleLogin')->with("err","Please, try again!");
        }
    }
    public function profile()
    {
        $profile = saleModel::where('sale_id',session('sale_id'))->first();
        return view('Sale.profile',['profile' => $profile]);
    }
    public function changePassword(Request $request)
    {
        $check = saleModel::where('sale_id',session()->get('sale_id'))->where('sale_pass',md5($request->password))->count();
        if($check == 0){
            $notification = $notification = array(
                'message' => trans('lang2.wrong_pass'),
                'alert-type' => 'error'
            );
        }else {
            saleModel::where('sale_id',session()->get('sale_id'))->update([
                'sale_pass' => md5($request->npassword),
            ]);
            $notification = $notification = array(
                'message' => trans('lang2.change_pass'),
                'alert-type' => 'success'
            );
        }
        return back()->with($notification);
    }
    public function changeAvatar(Request $request)
    {
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300,300)->save( public_path('/images/' . $filename) );
            saleModel::where('sale_id',session('sale_id'))->update([
                'sale_avatar' => 'images/' . $filename,
            ]);
        }
        return back();
    }
    public function addStudent()
    {
        $students = studentModel::where('sale_id',session()->get('sale_id'))->get();
        return view('Sale.Student.addStudent',['students' => $students]);
    }
    public function addStudentProcess(Request $request)
    {
        $count1 = studentModel::where('student_email',$request->txtEmail)->count();
        $count2 = studentModel::where('student_phone',$request->txtPhone)->count();
        $count = $count1 + $count2;
        if($count > 0)
        {
             $notification = array(
                    'message' => trans('lang2.failed_insert_std'),
                    'alert-type' => 'error'
                    );
        }else
        {
            studentModel::insert([
                'student_name' => $request->txtName,
                'student_phone' => $request->txtPhone,
                'student_email' => $request->txtEmail,
                'sale_id' => session()->get('sale_id')
            ]);
            $notification = array(
                    'message' => trans('lang2.success_insert_std'),
                    'alert-type' => 'success'
                    );
        }
        return back()->with($notification);
    }
    public function addStudentIntoClass(Request $request)
    {
        class_detailModel::insert([
            'class_id' => $request->class_id,
            'student_id' => $request->ddlStudent
        ]);
        $notification = array(
            'message' => trans('lang2.success_add_std'),
            'alert-type' => 'success'
        );
       return redirect()->back()->with($notification);
    }
    public function studentInterest()
    {
        $students = studentModel::where('sale_id',session()->get('sale_id'))->get();
        $majors = saleModel::getMajor();
        $courses = saleModel::getCourse();
        return view('Sale.Student.interest',['majors' => $majors,'courses' => $courses,'students' => $students]);
    }
    public function courseList($id)
    {
        $courses = courseModel::where('major_id',$id)->orderBy('course_name')->paginate(3);
        $major_name = majorModel::where('major_id',$id)->first();
        $major_name = $major_name->major_name;
        for($i = 0 ; $i < count($courses) ; $i++)
        {
            $open = classModel::where('course_id',$courses[$i]->course_id)->where('check',1)->count();
            $all = classModel::where('course_id',$courses[$i]->course_id)->count();
            $courses[$i]->all = $all;
            $courses[$i]->open = $open;
        }
        return view('Sale.Class.courseList',['courses' => $courses,'major_name' => $major_name]);
    }
    public function classList($id,$id2)
    {
        $course_name = courseModel::where('course_id',$id2)->first();
        $course_name = $course_name->course_name;
        $classes = classModel::where('course_id',$id2)->orderBy('class_name')->paginate(3);
        $major = majorModel::where('major_id',$id)->first();
        for($i = 0 ; $i < count($classes) ; $i++){
            $student = class_detailModel::where('class_id',$classes[$i]->class_id)->count();
            $classes[$i]->student = $student;
        }
        return view('Sale.Class.classList',['classes' => $classes,'course_name' => $course_name,'id' => $id,'major' => $major->major_name,'id2' => $id2]);
    }
    public function class_detail($id,$id2)
    {
        $students = class_detailModel::join('tblstudents','tblclass_detail.student_id','=','tblstudents.student_id')->join('tblsales','tblstudents.sale_id','=','tblsales.sale_id')->where('class_id',$id2)->orderBy('student_name')->get();
        for($i = 0 ; $i < count($students) ; $i++)
        {
            $j = $i+1;
            $students[$i]->number = $j;
        }
        $class = classModel::where('class_id',$id2)->first();
        $course = courseModel::where('course_id',$class->course_id)->first();
        $major = majorModel::where('major_id',$id)->first();
        $students_add = studentModel::whereNotIn('student_id', 
                                            class_detailModel::join('tblclasses','tblclass_detail.class_id','=','tblclasses.class_id')
                                                ->where('course_id',$course->course_id)
                                                ->select('student_id')
                                                ->get())
                                    ->where('sale_id',
                                            session()
                                            ->get('sale_id'))
                                    ->get();
        return view('Sale.Class.classDetail',['students' => $students,'course' => $course,'class' => $class,'major' => $major->major_name,'id' => $id,'students_add' => $students_add]);
    }
    // public function classListId($id)
    // {
    //     $classes = classModel::where('course_id',$id)->get();
    //     $course = courseModel::join('tblclasses','tblcourses.course_id','=','tblclasses.course_id')->where('tblclasses.course_id',$id)->select('course_name')->first();
    //     $major = courseModel::join('tblmajors','tblcourses.major_id','=','tblmajors.major_id')->where('tblcourses.course_id',$id)->first();
    //     $students = studentModel::whereNotIn('student_id', 
    //                                         class_detailModel::join('tblclasses','tblclass_detail.class_id','=','tblclasses.class_id')
    //                                             ->where('course_id',$id)
    //                                             ->select('student_id')
    //                                             ->get())
    //                                 ->where('sale_id',
    //                                         session()
    //                                         ->get('sale_id'))
    //                                 ->get();
    //     return view('Sale.classListId',['classes' => $classes,'students' => $students,'major' => $major]);
    // }
    public function deleteStudent($id)
    {
        studentModel::where('student_id',$id)->delete();
        $notification = array(
            'message' => 'Successfully deleted student!',
            'alert-type' => 'success'
        );
        return redirect()->route('addStudent')->with($notification);
    }
    public function addInterest(Request $request)
    {
        $count = classModel::where('course_id',$request->ddlCourse)->where('schedule_id',$request->ddlSchedule)->count();
        if($count == 0)
        {
             interestModel::insert([
                'student_id' => $request->ddlStudent,
                'interest' => ($request->ddlCourse . '|' . $request->ddlSchedule)
            ]);
         }else
         {
            $class = classModel::where('course_id',$request->ddlCourse)->where('schedule_id',$request->ddlSchedule)->first();
            class_detailModel::insert([
               'student_id' => $request->ddlStudent,
               'class_id' => $class->class_id
            ]);
            $interest = $request->ddlCourse;
            $schedule = $request->ddlSchedule;
            interestModel::where('student_id',$request->ddlStudent)->where('interest','like', $interest . '|%')->delete();
            interestModel::where('student_id',$request->ddlStudent)->where('interest','like', '%|' . $schedule)->delete();
         }  
         $notification = array(
            'message' => trans('lang2.success_add_interest'),
            'alert-type' => 'success'
        );
        return redirect()->route('studentInterest')->with($notification);
    }
    public function addInterestNew(Request $request)
    {
        studentModel::insert([
            'student_name' => $request->txtName,
            'student_phone' => $request->txtPhone,
            'student_email' => $request->txtEmail,
            'sale_id' => session()->get('sale_id')
        ]);
        $student_id = studentModel::where('student_name',$request->txtName)->first();
        interestModel::insert([
            'student_id' => $student_id->student_id,
            'interest' => ($request->ddlCourse . '|' . $request->ddlSchedule)
        ]);
        $notification = array(
            'message' => trans('lang2.success_add_interest'),
            'alert-type' => 'success'
        );
        return redirect()->route('studentInterest')->with($notification);
    }
}
