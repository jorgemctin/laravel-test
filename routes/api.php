<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Forma 1: trae password y token
// Route::get('/user/{id}', function($id){
// $user = DB::table('users')->where('id', $id)->get();
// return $user;
// });


//Sin password y token
// Route::get('/appointments/{id}', function($id){
//     $user = User::where('id', $id)->get();
//     return $user;
//     });



//Traer solo el objeto en concreto sin el array, sin el array
// Route::get('/user/{id}', function ($id) {
//     $user = User::find($id);
//     return $user;
// });

//Trae el primero no funciona
Route::get('/users/{id}', function($id){
    $user = User::find($id);
    $userFirst = User::where('id', $id)->first();
    return $user;
});

//APPOINTMENT BY USER
Route::get('/appointments/{id}', [AppointmentController::class, 'getAppointmentByUser']);
Route::get('/appointments', [AppointmentController::class, 'getAllAppointments']);
Route::post('/appointments', [AppointmentController::class, 'createAppointment']);
Route::put('/appointment/{id}', [AppointmentController::class, 'updateAppointment'])->middleware('auth:sanctum');

//SERVICE CONTROLLER 
Route::post('/services', [ServiceController::class, 'createService'])->middleware(['auth:sanctum', 'isAdmin']);
Route::get('/services/getAll', [ServiceController::class, 'getAllServices']);
Route::get('/services/description/{description}', [ServiceController::class, 'getServiceByDescription']);

//AUTH CONTROLLER
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/profile', [AuthController::class, 'profile'])->middleware('auth:sanctum');


//USER CONTROLLER
Route::delete('/user/delete', [UserController::class, 'deleteMyAccount'])->middleware('auth:sanctum');
Route::post('/user/{id}', [UserController::class, 'restoreAccount']);
Route::put('/user/{id}', [UserController::class, 'updateProfile'])->middleware('auth:sanctum');

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


