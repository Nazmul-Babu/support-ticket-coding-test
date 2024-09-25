<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthCheckMiddleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class DashboardController extends Controller 
{
  public function __construct(){
     $this->middleware('AuthCheck');
  }
  

  public function dashboard()
  {
    $data = [];
    $data['active_menu'] = 'dashboard';
    $data['page_title'] = 'Dashboard';
    return view('backend.pages.dashboard', compact('data'));
  }
}
