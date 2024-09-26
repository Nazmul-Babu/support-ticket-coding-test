<?php

use App\Http\Controllers\AuthenticstionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
route::redirect('/','registration');
Route::match(['get','post'],'registration',[AuthenticstionController::class,'registration'])->name('registration');
Route::match(['get','post'],'login',[AuthenticstionController::class,'login'])->name('login');
Route::get('logout', [AuthenticstionController::class, 'logout'])->name('logout');
Route::match(['get','post'],'dashboard',[DashboardController::class,'dashboard'])->name('dashboard');
//profile 
Route::get('profile', [ProfileController::class, 'profile'])->name('profile');
Route::post('profile-info/update', [ProfileController::class, 'profile_info_update'])->name('profile.info.update');
Route::post('profile-password/update', [ProfileController::class, 'profile_password_update'])->name('profile.password.update');

//ticket
route::match(['get','post'],'ticket-add',[TicketController::class,'ticket_add'])->name('ticket.add');
route::match(['get','post'],'ticket-list',[TicketController::class,'ticket_list'])->name('ticket.list');
route::match(['get','post'],'ticket-details/{ticket_id}',[TicketController::class,'ticket_details'])->name('ticket.details');
route::post('ticket-status',[TicketController::class,'ticket_status'])->name('ticket.status');

