<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
  	public function testfunction(Request $request){

  		$name=$request->testname;

  		if ($name=='laravel') {
  			echo "success";

  			$notification = array(
                'message' => 'Successfully get laravel data!',
                'alert-type' => 'success'
            );

  		} else if ($name=='found') {
  			echo "info";

  			$notification = array(
                'message' => 'info found data!',
                'alert-type' => 'info'
            );


  		} 
  		else if ($name=='notfound') {
  			echo "warning";
  			$notification = array(
                'message' => 'Warning get not found data!',
                'alert-type' => 'warning'
            );

  		}else {
  			echo "error";
  			$notification = array(
                'message' => 'Error! input is empty !',
                'alert-type' => 'error'
            );

  		}

  		return back()->with($notification);
  		
  		
  	}
    public function findProductName(Request $request){


        //if our chosen id and products table prod_cat_id col match the get first 100 data 

        //$request->id here is the id of our chosen option id
        $data=Product::select('productname','id')->where('prod_cat_id',$request->id)->take(100)->get();
        return response()->json($data);//then sent this data to ajax success
    }


}
