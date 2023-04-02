<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     /**
      * 履歴表示機能
      */
    public function index()
    {
        $logs = Log::orderBy('created_at','DESC')->take(30)->get();

        return view('home' ,compact('logs'));
    }
}
