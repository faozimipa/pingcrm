<?php

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

// Auth
Route::get('login')->name('login')->uses('Auth\LoginController@showLoginForm')->middleware('guest');
Route::post('login')->name('login.attempt')->uses('Auth\LoginController@login')->middleware('guest');
Route::post('logout')->name('logout')->uses('Auth\LoginController@logout');

// Dashboard
Route::get('/')->name('dashboard')->uses('DashboardController')->middleware('auth');

// Users
Route::get('users')->name('users')->uses('UsersController@index')->middleware('remember', 'auth');
Route::get('users/create')->name('users.create')->uses('UsersController@create')->middleware('auth');
Route::post('users')->name('users.store')->uses('UsersController@store')->middleware('auth');
Route::get('users/{user}/edit')->name('users.edit')->uses('UsersController@edit')->middleware('auth');
Route::put('users/{user}')->name('users.update')->uses('UsersController@update')->middleware('auth');
Route::delete('users/{user}')->name('users.destroy')->uses('UsersController@destroy')->middleware('auth');
Route::put('users/{user}/restore')->name('users.restore')->uses('UsersController@restore')->middleware('auth');

// Images
Route::get('/img/{path}', 'ImagesController@show')->where('path', '.*');

// Roles
Route::get('roles')->name('roles')->uses('RolesController@index')->middleware('auth');
Route::get('roles/create')->name('roles.create')->uses('RolesController@create')->middleware('auth');
Route::post('roles')->name('roles.store')->uses('RolesController@store')->middleware('auth');
Route::get('roles/{role}/edit')->name('roles.edit')->uses('RolesController@edit')->middleware('auth');
Route::put('roles/{role}')->name('roles.update')->uses('RolesController@update')->middleware('auth');
Route::delete('roles/{role}')->name('roles.destroy')->uses('RolesController@destroy')->middleware('auth');
Route::put('roles/{role}/restore')->name('roles.restore')->uses('RolesController@restore')->middleware('auth');

// Permissions
Route::get('permissions')->name('permissions')->uses('PermissionsController@index')->middleware('auth');
Route::get('permissions/assign')->name('permissions.assign')->uses('PermissionsController@assign')->middleware('auth');
Route::post('permissions/assign')->name('permissions.assign.update')->uses('PermissionsController@assignUpdate')->middleware('auth');
Route::get('permissions/create')->name('permissions.create')->uses('PermissionsController@create')->middleware('auth');
Route::post('permissions')->name('permissions.store')->uses('PermissionsController@store')->middleware('auth');
Route::get('permissions/{permission}/edit')->name('permissions.edit')->uses('PermissionsController@edit')->middleware('auth');
Route::put('permissions/{permission}')->name('permissions.update')->uses('PermissionsController@update')->middleware('auth');
Route::delete('permissions/{permission}')->name('permissions.destroy')->uses('PermissionsController@destroy')->middleware('auth');
Route::put('permissions/{permission}/restore')->name('permissions.restore')->uses('PermissionsController@restore')->middleware('auth');


// Organizations
Route::get('organizations')->name('organizations')->uses('OrganizationsController@index')->middleware('remember', 'auth');
Route::get('organizations/create')->name('organizations.create')->uses('OrganizationsController@create')->middleware('auth');
Route::post('organizations')->name('organizations.store')->uses('OrganizationsController@store')->middleware('auth');
Route::get('organizations/{organization}/edit')->name('organizations.edit')->uses('OrganizationsController@edit')->middleware('auth');
Route::put('organizations/{organization}')->name('organizations.update')->uses('OrganizationsController@update')->middleware('auth');
Route::delete('organizations/{organization}')->name('organizations.destroy')->uses('OrganizationsController@destroy')->middleware('auth');
Route::put('organizations/{organization}/restore')->name('organizations.restore')->uses('OrganizationsController@restore')->middleware('auth');

// Contacts
Route::get('contacts')->name('contacts')->uses('ContactsController@index')->middleware('remember', 'auth');
Route::get('contacts/create')->name('contacts.create')->uses('ContactsController@create')->middleware('auth');
Route::post('contacts')->name('contacts.store')->uses('ContactsController@store')->middleware('auth');
Route::get('contacts/{contact}/edit')->name('contacts.edit')->uses('ContactsController@edit')->middleware('auth');
Route::put('contacts/{contact}')->name('contacts.update')->uses('ContactsController@update')->middleware('auth');
Route::delete('contacts/{contact}')->name('contacts.destroy')->uses('ContactsController@destroy')->middleware('auth');
Route::put('contacts/{contact}/restore')->name('contacts.restore')->uses('ContactsController@restore')->middleware('auth');

// Reports
Route::get('reports')->name('reports')->uses('ReportsController')->middleware('auth');

// 500 error
Route::get('500', function () {
    echo $fail;
});
