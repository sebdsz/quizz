<?php

namespace App\Http\Controllers;

use App\User;
use App\Theme;
use App\Result;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;

class ResultController extends Controller
{

   public function index()
   {
       $results = Result::all();

       return view('admin.results.index', compact('results'));
   }

}


