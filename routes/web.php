<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', function (\Illuminate\Http\Request $request) {
    $id = $request->session()->get('user.id');
    if ($id) {
        return redirect('/projects');
    }

    return view('register');
});
Route::post('/register', [UserController::class, 'register']);

Route::get('/login', function (\Illuminate\Http\Request $request) {
    $id = $request->session()->get('user.id');
    if ($id) {
        return redirect('/projects');
    }

    return view('login');
});
Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);

Route::get('/tasks', [TaskController::class, 'show']);
Route::get('/create-task', function (\Illuminate\Http\Request $request) {
    $role = $request->session()->get('user.role');
    if ($role != 'teacher') return redirect('/tasks');

    return view('create-task');
});
Route::post('/create-task', [TaskController::class, 'create']);

Route::get('/users', [UserController::class, 'show']);
Route::get('/change-role/{id}/{role}', [UserController::class, 'changeRole']);

Route::get('/apply/{taskId}', [TaskController::class, 'apply']);
Route::get('/applicants/{taskId}', [TaskController::class, 'applicants']);
Route::get('/approve/{taskId}/{userId}', [TaskController::class, 'approve']);
