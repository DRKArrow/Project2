<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\saleModel;
Route::get('/', function () {
    return view('welcome');
});
	Route::get('Admin/login.html','adminController@login')->name('adminLogin');
	Route::post('Admin/loginProcess','adminController@loginProcess')->name('adminLoginProcess');
	Route::get('Sale/login.html','saleController@login')->name('saleLogin');
	Route::post('Sale/loginProcess','saleController@loginProcess')->name('saleLoginProcess');

Route::get('changeLanguage-{language}','languageController@changeLanguage')->name('changeLanguage');

Route::middleware('CheckSessionAdmin')->group(function(){
	Route::group(['prefix' => 'Admin'], function(){
		Route::get('/',function(){
			return redirect()->route('Admindashboard');
		});
		Route::get('dashboard.html','adminController@mainPage')->name('Admindashboard');
		
		Route::get('adminLogout',function(){
			Session::forget('admin_email');
			Session::forget('admin_name');
			return redirect()->route('adminLogin');
		})->name('adminLogout');
		Route::group(['prefix' => 'Sales'],function(){
			Route::get('/', function(){
				return redirect()->route('salesList');
			});
			Route::get('salesList.html','saleController@salesList')->name('salesList');
			Route::get('addSale.html',function() {
				return view('Admin.Sale.addSale');
			})->name('addSale');
			Route::post('addSaleProcess','saleController@addSaleProcess')->name('addSaleProcess');
		});
		Route::group(['prefix' => 'Majors'],function(){
			Route::get('/', function(){
				return redirect()->route('majorsList');
			});
			Route::get('majorsList.html','majorController@majorsList')->name('majorsList');
			Route::post('addMajorProcess','majorController@addMajorProcess')->name('addMajorProcess');
			Route::get('deleteMajor-{id}','majorController@deleteMajor')->name('deleteMajor');
			Route::post('editMajor','majorController@editMajor')->name('editMajor');
		});
		Route::group(['prefix' => 'Courses'],function(){
			Route::get('/', function(){
				return redirect()->route('coursesList');
			});
			Route::get('coursesList.html','courseController@coursesList')->name('coursesList');
			Route::post('addCourseProcess','courseController@addCourseProcess')->name('addCourseProcess');
			Route::get('deleteCourse-{id}','courseController@deleteCourse')->name('deleteCourse');
			Route::post('editCourse','courseController@editCourse')->name('editCourse');
		});
		Route::group(['prefix' => 'Schedules'],function(){
			Route::get('/', function(){
				return redirect()->route('schedulesList');
			});
			Route::get('schedulesList.html','scheduleController@schedulesList')->name('schedulesList');
			Route::post('addScheduleProcess','scheduleController@addScheduleProcess')->name('addScheduleProcess');
			Route::get('deleteSchedule-{id}','scheduleController@deleteSchedule')->name('deleteSchedule');
		});
		Route::group(['prefix' => 'Classes'],function(){
			Route::get('/', function(){
				return redirect()->route('classesList');
			});
			Route::get('classesList.html','classController@classesList')->name('classesList');
			Route::get('classDetail-{id}.html','classController@classDetail')->name('classDetail');
			Route::post('addClassProcess','classController@addClassProcess')->name('addClassProcess');
			Route::get('deleteClass-{id}','classController@deleteClass');
			Route::get('OpenClass-{id}','classController@OpenClass');
			
		});
		Route::group(['prefix' => 'Interests'],function(){
			Route::get('interestsList.html','interestController@interestsList')->name('interestsList');
			Route::get('addClass-{id}','interestController@addClass');
			Route::get('interestDetail-{id}.html','interestController@interestDetail')->name('interestDetail');
		});
	});
});

Route::middleware('CheckSessionSale')->group(function(){
	Route::group(['prefix' => 'Sale'], function(){
		Route::get('changeLanguage-{language}','languageController@changeLanguage2');
		Route::get('/',function(){
			return redirect()->route('dashboard');
		});
		Route::get('dashboard.html','saleController@dashboard')->name('dashboard');
		Route::get('myProfile.html','saleController@profile')->name('profile');
		Route::post('changePassword','saleController@changePassword')->name('changePassword');
		Route::post('changeAvatar','saleController@changeAvatar')->name('changeAvatar');
		Route::get('saleLogout',function(){
			Session::forget('sale_id');
			Session::forget('sale_email');
			Session::forget('sale_name');
			return redirect()->route('saleLogin');
		})->name('saleLogout');	
		Route::get('deleteStudent-{id}','saleController@deleteStudent');
		Route::group(['prefix' => 'Student'],function(){
			Route::get('addStudent.html','saleController@addStudent')->name('addStudent');
			Route::post('addStudentProcess','saleController@addStudentProcess')->name('addStudentProcess');
			Route::get('Interest.html','saleController@studentInterest')->name('studentInterest');
			Route::post('addInterest','saleController@addInterest')->name('addInterest');
			Route::post('addInterestNew','saleController@addInterestNew')->name('addInterestNew');
		});
		Route::group(['prefix' => 'Class'],function(){
			Route::post('addStudentIntoClass','saleController@addStudentIntoClass')->name('addStudentIntoClass');
			Route::get('courseList-{id}.html','saleController@courseList')->name('courseList');
			Route::get('/{id}/classList-{id2}.html','saleController@classList')->name('classList');
			Route::get('/{id}/class_detail-{id2}.html','saleController@class_detail')->name('class_detail');
		});
	});
});

Route::group(['prefix' => 'Ajax'], function(){
	Route::get('SaleStat','AjaxController@SaleStat');
	Route::get('getCourses','AjaxController@getCourses');
	Route::get('getSchedules','AjaxController@getSchedules');
	Route::get('getCourses_classList','AjaxController@getCourses_classList');
	Route::get('getStudent','AjaxController@getStudent');
	Route::get('getStudentName','AjaxController@getStudentName');
	Route::get('ViewStats','AjaxController@ViewStats');
	Route::get('Notification','AjaxController@Notification');
	Route::get('Notification2','AjaxController@Notification2');
	Route::get('getMajor','AjaxController@getMajor');
	Route::get('CheckStudent','AjaxController@CheckStudent');
	Route::get('CheckClass','AjaxController@CheckClass');
	Route::get('CheckStudentSale','AjaxController@CheckStudentSale');
	Route::get('CheckOpenClass','AjaxController@CheckOpenClass');
	Route::get('getCourseInterest','AjaxController@getCourseInterest');
	Route::get('CheckInterest','AjaxController@CheckInterest');
	Route::get('CheckDeleteCourse','AjaxController@CheckDeleteCourse');
	Route::get('CheckDeleteMajor','AjaxController@CheckDeleteMajor');
	Route::get('CheckEditCourse','AjaxController@CheckEditCourse');
	Route::get('SearchCourse','AjaxController@SearchCourse');
	Route::get('SearchClass','AjaxController@SearchClass');
});



Route::get('testModel',function(){
	$majors = saleModel::getMajor();
    $courses = saleModel::getCourse();
	return view('test',['majors' => $majors,'courses' => $courses]);
});
Route::get('test',function()
{
	return view('Sale.newmaster');
});
Route::get('test2',function()
{
	return view('Sale.dashboard');
});

