<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use View;
use Hash;
use App\Category;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        setlocale(LC_TIME, env('LOCALE', 'en'));
    }
}
