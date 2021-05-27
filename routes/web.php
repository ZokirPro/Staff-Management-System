<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
    return redirect()->route('login');
});



Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::namespace('admin')->prefix('admin')->name('admin.')->middleware(['auth','can:admin-access'])->group(function () {
    
    /**************************************************************** ADMIN LOGIN  ****************************************/
    Route::get('/', 'AdminController@index')->name('index');
   

    /**************************************************************** EMPLOYEES  ****************************************/
    Route::get('/employees/list', 'EmployeeController@index')->name('employees.index');
    Route::get('/employees/add', 'EmployeeController@create')->name('employees.create');
    Route::post('/employees', 'EmployeeController@store')->name('employees.store');

     /**************************************************************** ATTENDANCE  ****************************************/
    Route::get('/employees/attendance', 'EmployeeController@attendance')->name('employees.attendance');
    Route::post('/employees/attendance', 'EmployeeController@attendance')->name('employees.attendance');
    Route::delete('/employees/attendance/{attendance_id}', 'EmployeeController@attendanceDelete')->name('employees.attendance.delete');
    Route::delete('/employees/{employee_id}', 'EmployeeController@destroy')->name('employees.delete');
    

    /**************************************************************** EXPENSES  ****************************************/
    Route::get('/expenses/list', 'ExpenseController@index')->name('expenses.index');
    Route::put('/expenses/{expense_id}', 'ExpenseController@update')->name('expenses.update');
});


Route::namespace('Employee')->prefix('employee')->name('employee.')->middleware(['auth','can:employee-access'])->group(function () {
    
    /**************************************************************** EMPLOYEE PROFILE  ****************************************/
    Route::get('/', 'EmployeeController@index')->name('index');
    Route::get('/profile', 'EmployeeController@profile')->name('profile');
    Route::get('/profile-edit/{employee_id}', 'EmployeeController@profile_edit')->name('profile-edit');
    Route::put('/profile/{employee_id}', 'EmployeeController@profile_update')->name('profile-update');
    
     /**************************************************************** ATTENDANCE  ****************************************/
    Route::get('/attendance/attendances', 'AttendanceController@index')->name('attendance.index');
    Route::post('/attendance/attendances', 'AttendanceController@index')->name('attendance.index');
    Route::get('/attendance/register', 'AttendanceController@create')->name('attendance.create');
    Route::post('/attendance/{employee_id}', 'AttendanceController@store')->name('attendance.store');
    Route::put('/attendance/{attendance_id}', 'AttendanceController@update')->name('attendance.update');
    

     /**************************************************************** EXPENSES  ****************************************/
    Route::get('/expenses/list-expenses', 'ExpenseController@index')->name('expenses.index');
    Route::get('/expenses/claim-expense', 'ExpenseController@create')->name('expenses.create');
    Route::post('/expenses/{employee_id}', 'ExpenseController@store')->name('expenses.store');
    Route::get('/expenses/edit-expense/{expense_id}', 'ExpenseController@edit')->name('expenses.edit');
    Route::put('/expenses/{expense_id}', 'ExpenseController@update')->name('expenses.update');
    Route::delete('/expenses/{expense_id}', 'ExpenseController@destroy')->name('expenses.delete');
});