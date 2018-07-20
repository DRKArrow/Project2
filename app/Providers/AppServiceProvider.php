<?php

namespace App\Providers;
use App\interestModel;
use App\classModel;
use App\majorModel;
use App\saleModel;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        view()->composer('Admin.master', function($view)
        {
            $count = interestModel::select('interest')->distinct()->get();
            $count = count($count);
            $today = date('Y-m-d');
            $one_week = date("Y-m-d", strtotime("-1 week"));
            $count2 = classModel::where('check',1)->whereBetween('class_startdate',[$one_week,$today])->get();
            $view->with(['count' => $count,'count2' => $count2]);
        });
        view()->composer('Sale.newmaster', function($view)
        {
            $sale = saleModel::where('sale_id',session('sale_id'))->first();
            $majors = majorModel::all();
            $classes = classModel::where('check',0)->get();
            for($i = 0 ; $i < count($classes) ; $i++)
            {
                $name_explode = explode('(',$classes[$i]->class_name);
                $name = $name_explode[0];
                $classes[$i]->name = $name;
                $time = explode(')',$name_explode[1]);
                $time = $time[0];
                $classes[$i]->time = $time;
                $type = majorModel::join('tblcourses','tblcourses.major_id','=','tblmajors.major_id')->join('tblclasses','tblclasses.course_id','=','tblcourses.course_id')->where('class_id',$classes[$i]->class_id)->first();
                $major_id = $type->major_id;
                $type = $type->major_name;
                $classes[$i]->major_id = $major_id;
                $classes[$i]->type = $type;
            }
            $view->with(['classes' => $classes,'majors' => $majors,'sale' => $sale]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
