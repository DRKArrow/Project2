<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\scheduleModel;
use App\classModel;
class scheduleController extends Controller
{
    //
    public function schedulesList()
    {
    	$schedules = scheduleModel::all();
        for($i = 0 ; $i < count($schedules) ; $i++)
        {
            $classes = classModel::where('schedule_id',$schedules[$i]->schedule_id)->orderBy('class_name')->get();
            $classes_name = array();
            for($j = 0 ;$j < count($classes) ; $j++)
            {
                $classes_name[$j] = $classes[$j]->class_name;
            }
            $schedules[$i]->class = $classes_name;
        }
    	return view('Admin.Schedule.schedulesList',['schedules' => $schedules]);
    }
    public function addScheduleProcess(Request $request)
    {
        $obj = new scheduleModel();
        $schedule_name = $request->txtName;
        $timeStartDef = $request->txtTimeStart;
        $timeEndDef = $request->txtTimeEnd;
        $timeStart_explode = explode(' ',$timeStartDef);
        $timeStart_AMPM = $timeStart_explode[1];
        $timeEnd_explode = explode(' ',$timeEndDef);
        $timeEnd_AMPM = $timeEnd_explode[1];
        $timeStart = $timeStart_explode[0];
        $timeEnd = $timeEnd_explode[0];
        $timeStart_explode = explode(':',$timeStart);
        $timeStart_hour = $timeStart_explode[0];
        $timeStart_minute = $timeStart_explode[1];
        $timeEnd_explode = explode(':',$timeEnd);
        $timeEnd_hour = $timeEnd_explode[0];
        $timeEnd_minute = $timeEnd_explode[1];
        if($timeStart_AMPM == 'PM')
        {
            if($timeStart_hour == '12')
            {

            }else
            {
                $timeStart_hour += 12;
            }   
        }
        if($timeEnd_AMPM == 'PM')
        {
            if($timeEnd_hour == '12')
            {

            }else
            {
                $timeEnd_hour += 12;
            }
        }

        $date_select_one=$request->date_select_one;
        $date_select_two=$request->date_select_two;
        $date_select_three=$request->date_select_three;
        $dates = array($date_select_one,$date_select_two,$date_select_three);
        $t = $dates[0];
        for($i=0;$i<3;$i++)
        {
            for($j=2; $j > $i; $j--){
                if($dates[$j] < $dates[$j-1])
                {
                    $t = $dates[$j];
                    $dates[$j] = $dates[$j-1];
                    $dates[$j-1] = $t;
                }
            }
        }
        $schedule_name = $dates[0] . ',' . $dates[1] . ',' . $dates[2];
        $timeStart = $timeStart_hour . ':' . $timeStart_minute;
        $timeEnd = $timeEnd_hour . ':' . $timeEnd_minute;
        $check = scheduleModel::where('schedule_name','like',$schedule_name . '%')->where('schedule_start','<',$timeStart)->where('schedule_end','>',$timeStart)->count();
        if($check > 0)
        {
            $notification = array(
                        'message' => trans('lang3.failed_insert_schedule'),
                        'alert-type' => 'error'
                    );
        }else 
        {
            $ScheduleName = $schedule_name . ' (' . $timeStartDef . ' - ' . $timeEndDef . ')';
            $count = scheduleModel::where('schedule_name',$ScheduleName)->count();
            if($count == 0)
            {
                $obj->schedule_name = $ScheduleName;
                $obj->schedule_start = $timeStart;
                $obj->schedule_end = $timeEnd;
                scheduleModel::insertSchedule($obj);
                $notification = array(
                        'message' => trans('lang.success_insert_schedule'),
                        'alert-type' => 'success'
                    );
            }else
            {
                $notification = array(
                        'message' => trans('lang.failed_insert_schedule'),
                        'alert-type' => 'error'
                    );
            }
        }
        
        
        return redirect()->route('schedulesList')->with($notification);
    }
    public function deleteSchedule($id)
    {
        $count = classModel::where('schedule_id',$id)->count();
        if($count == 0)
        {
            scheduleModel::deleteSchedule($id);
            $notification = array(
                    'message' => trans('lang.success_delete_schedule'),
                    'alert-type' => 'success'
                );
        }else
        {
            $notification = array(
                    'message' => trans('lang.failed_delete_schedule'),
                    'alert-type' => 'error'
                );
        }
    	
    	return redirect()->route('schedulesList')->with($notification);
    }
}
