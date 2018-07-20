<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Input;
use App;
use Lang;

class languageController extends Controller
{
    //
    // public function changeLanguage(Request $request)
    // {
    // 	if($request->ajax()) {
    //         $request->session()->put('locale', $request->locale);
    //     }
    // }
    public function changeLanguage($language)
    {
        if($language){
            session()->put('locale', $language);
        }
        return back();
    }
}
