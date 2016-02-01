<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Created By Dara on 2/1/2016
     * the site main page
     */
    public function index(){
        return view('main.index')->with(['title'=>'صفحه اصلی']);
    }
}
