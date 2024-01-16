<?php

namespace App\Http\Controllers;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Leave;
use Illuminate\Validation\Rules\Can;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

//Google
Route::get('/login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('login.callback');


Route::middleware('auth')->namespace('App\Http\Controllers')->group(function () {
    // User routes here
    //  Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/attendance', 'AttendanceController@attendance')->name('clockin.page');

    Route::post('/attendance/clockin', 'AttendanceController@clockInAjax')->name('clockin');
    Route::post('/attendance/clockout', 'AttendanceController@clockOutAjax');

    // Route::get('/leave/request', 'LeaveController@leaverequest')->name('leave.submit');
    Route::get('/leave', 'LeaveController@indexx');
    Route::post('/leave', 'LeaveController@submitleaverequest')->name('leave.submit');
    Route::get('/leave/view/{id}', 'LeaveController@view')->name('leave.show');
    Route::get('/leave/edit/{id}', 'LeaveController@edit')->name('leave.edit');
    Route::put('/leave/update/{id}', 'LeaveController@update')->name('leave.update');

    Route::get('/employee', 'EmployeeUserController@index')->name('employees');
    Route::post('/get-employees', 'EmployeeUserController@getEmployees')->name('get-employees');
    Route::post('/search-employees', 'EmployeeUserController@searchEmployees')->name('search-employees');

    Route::get('/posts', 'PostController@index')->name('posts.index');
    Route::post('/posts', 'PostController@store')->name('posts.store');
    Route::post('/posts/toggle-like', 'PostController@toggleLike')->name('posts.toggle-like');

    Route::get('/marksheet', 'MarksheetController@index')->name('marksheet.index');
    Route::post('/marksheet', 'MarksheetController@store')->name('marksheet.store');

    Route::post('/marksheet/update', 'MarksheetController@update')->name('marksheet.update');
    Route::get('/download/marksheet/{id}', 'MarksheetController@download')->name('user.downloadmarks');

    Route::get('/email-send', 'EmailController@sendEmail')->name('send-email');

    Route::get('/upload', 'ImageController@index')->name('upload');
    Route::post('/upload', 'imagecontroller@uploadImage')->name('upload.image');
});


Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function () {
    Route::match(['get', 'post'], 'login', 'AdminController@login');
    Route::group(['middleware' => ['auth:admin']], function () {
        Route::group(['middleware' => ['permission:dashboard_view']], function () {
            Route::get('dashboard', 'AdminController@dashboard');
        });
        Route::get('logout', 'AdminController@logout');
        Route::group(['middleware' => ['permission:attendance_view']], function () {
            Route::get('attendance', 'AdminController@index')->name('attendance.index');
            Route::get('attendance/edit/{id}', 'AdminController@edit')->name('attendance.edit');
            Route::put('attendance/update/{id}', 'AdminController@update')->name('attendance.update');
        });

        Route::group(['middleware' => ['permission:leave_view']], function () {
            Route::get('leave', 'LeaveStatusController@index')->name('leave_status');
            Route::post('leave/approve/{id}', 'LeaveStatusController@approve')->name('leave.approve');
            Route::post('leave/reject/{id}', 'LeaveStatusController@reject')->name('leave.reject');
            Route::get('leave/view/{id}', 'LeaveStatusController@view')->name('leave.view');
        });

        Route::group(['middleware' => ['permission:department_view']], function () {
            Route::get('department', 'DepartmentController@index')->name('department_index');
            Route::post('department', 'DepartmentController@store')->name('departments.store');
            Route::delete('department/{id}', 'DepartmentController@destroy')->name('departments.destroy');
            Route::get('department/edit/{id}', 'DepartmentController@edit')->name('department.edit');
            Route::put('department/update/{id}', 'DepartmentController@update')->name('department.update');
            Route::put('department/toggle-status/{id}', 'DepartmentController@toggleStatus')->name('department.status');
            Route::get('validate-name', 'DepartmentController@validatedepartmentname')->name('name.validation');
        });

        Route::group(['middleware' => ['permission:employee_view']], function () {
            Route::get('employee', 'EmployeeController@index')->name('employee.index');
            Route::post('employee', 'EmployeeController@store')->name('employees.store');
            Route::delete('employee/{id}', 'EmployeeController@destroy')->name('employees.destroy');
            Route::put('employee/toggle-status/{id}', 'EmployeeController@toggleStatus')->name('employees.status');
            Route::get('employee/edit/{id}', 'EmployeeController@edit')->name('employees.edit');
            Route::put('employee/update/{id}', 'EmployeeController@update')->name('employees.update');
            Route::get('validate-email', 'EmployeeController@validateuseremail')->name('email.validation');
            Route::get('validate-mobile', 'EmployeeController@validateusermobile')->name('mobile.validation');
        });

        Route::group(['middleware' => ['permission:marksheet_view']], function () {
            Route::get('marksheet', 'MarksheetController@index')->name('marksheet.index');
            Route::get('download/marksheet/{id}', 'MarksheetController@download')->name('download.marksheet');
        });

        // Route::get('notification','NotificationController@index')->name('notification');
        Route::put('notification/update/{id}', 'NotificationController@update')->name('notification.update');

        Route::group(['middleware' => ['permission:role_view']], function () {
            Route::get('role', 'RoleController@index')->name('role.index');
            Route::post('roles/store', 'RoleController@storeRole')->name('roles.store');
            Route::get('roles/edit/{id}', 'RoleController@edit')->name('roles.edit');
            Route::put('roles/update/{id}', 'RoleController@update')->name('roles.update');
            Route::delete('roles/{id}', 'RoleController@destroy')->name('roles.destroy');
        });

        Route::group(['middleware' => ['permission:adminuser_view']], function () {
            Route::get('adminuser', 'AdminUserController@index')->name('adminusers.index');
            Route::post('adminuser', 'AdminUserController@store')->name('adminusers.store');
            Route::get('adminuser/edit/{id}', 'AdminUserController@edit')->name('adminuser.edit');
            Route::put('adminuser/update/{id}', 'AdminUserController@update')->name('adminuser.update');
            Route::get('validate-admin-email', 'AdminUserController@validateuseremail')->name('email.validation');
        });
    });
});
