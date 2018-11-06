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

Route::get('/', function () {
//    return view('welcome');

//	$token = $request->cookie('login_session');
//	dd($token);

    return View('layouts.master');
//})->middleware('auth');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');




// Role Management

Route::get('role', [

    'uses' => 'RoleController@index',
//    'middleware' => 'auth',
//    'middleware' => ['roles:root','can:Can_Register'],
    'middleware' => ['roles:root'],
//    'middleware' => ['can:Can_Register'],

]);

Route::get('role/details', [

    'uses' => 'RoleController@show',
//    'middleware' => 'auth',
//    'middleware' => ['roles:root','can:Can_Register'],
//    'middleware' => ['roles:root'],
//    'middleware' => ['can:Can_Register'],

]);


Route::post('role/store', [

    'uses' => 'RoleController@store',
//    'name' => 'rolestore',
//    'middleware' => 'auth',
//    'middleware' => ['roles:root','can:Can_Register'],
//    'middleware' => ['roles:root'],
//    'middleware' => ['can:Can_Register'],

]);

Route::post('role/edit', [

    'uses' => 'RoleController@edit',
//    'name' => 'rolestore',
//    'middleware' => 'auth',
//    'middleware' => ['roles:root','can:Can_Register'],
//    'middleware' => ['roles:root'],
//    'middleware' => ['can:Can_Register'],

]);

Route::post('role/update', [

    'uses' => 'RoleController@update',
//    'name' => 'rolestore',
//    'middleware' => 'auth',
//    'middleware' => ['roles:root','can:Can_Register'],
//    'middleware' => ['roles:root'],
//    'middleware' => ['can:Can_Register'],

]);

Route::post('role/destroy', [

    'uses' => 'RoleController@destroy',
//    'name' => 'rolestore',
//    'middleware' => 'auth',
//    'middleware' => ['roles:root','can:Can_Register'],
//    'middleware' => ['roles:root'],
//    'middleware' => ['can:Can_Register'],

]);


// Permission Management


Route::get('permission', [

    'uses' => 'PermissionController@index',
//    'middleware' => 'auth',
//    'middleware' => ['roles:root','can:Can_Register'],
//    'middleware' => ['roles:root','roles:admin'],
    'middleware' => ['roles:root'],
//    'middleware' => ['can:Can_Register'],

]);

Route::get('permission/details', [

    'uses' => 'PermissionController@show',
//    'middleware' => 'auth',
//    'middleware' => ['roles:root','can:Can_Register'],
//    'middleware' => ['roles:root'],
//    'middleware' => ['can:Can_Register'],

]);


Route::post('permission/store', [

    'uses' => 'PermissionController@store',
//    'name' => 'rolestore',
//    'middleware' => 'auth',
//    'middleware' => ['roles:root','can:Can_Register'],
//    'middleware' => ['roles:root'],
//    'middleware' => ['can:Can_Register'],

]);

Route::post('permission/edit', [

    'uses' => 'PermissionController@edit',
//    'name' => 'rolestore',
//    'middleware' => 'auth',
//    'middleware' => ['roles:root','can:Can_Register'],
//    'middleware' => ['roles:root'],
//    'middleware' => ['can:Can_Register'],

]);


Route::post('permission/update', [

    'uses' => 'PermissionController@update',
//    'name' => 'rolestore',
//    'middleware' => 'auth',
//    'middleware' => ['roles:root','can:Can_Register'],
//    'middleware' => ['roles:root'],
//    'middleware' => ['can:Can_Register'],

]);

Route::post('permission/destroy', [

    'uses' => 'PermissionController@destroy',
//    'name' => 'rolestore',
//    'middleware' => 'auth',
//    'middleware' => ['roles:root','can:Can_Register'],
//    'middleware' => ['roles:root'],
//    'middleware' => ['can:Can_Register'],

]);



// User Management


Route::get('user', [

    'uses' => 'UserController@index',
//    'middleware' => 'auth',
//    'middleware' => ['roles:root','can:Can_Register'],
//    'middleware' => ['roles:root','roles:admin'],
//    'middleware' => ['roles:root'],
//    'middleware' => ['can:Can_Register'],
//    'middleware' => ['can:Can_Register','can:Can_Destroy'],

]);

Route::get('user/details', [

    'uses' => 'UserController@show',
//    'middleware' => 'auth',
//    'middleware' => ['roles:root','can:Can_Register'],
//    'middleware' => ['roles:root'],
//    'middleware' => ['can:Can_Register'],

]);


Route::post('user/store', [

    'uses' => 'UserController@store',
//    'name' => 'rolestore',
//    'middleware' => 'auth',
//    'middleware' => ['roles:root','can:Can_Register'],
//    'middleware' => ['roles:root'],
//    'middleware' => ['can:Can_Register'],

]);
//Route::post('user/store', 'UserController@store');

Route::post('user/edit', [

    'uses' => 'UserController@edit',
//    'name' => 'rolestore',
//    'middleware' => 'auth',
//    'middleware' => ['roles:root','can:Can_Register'],
//    'middleware' => ['roles:root'],
//    'middleware' => ['can:Can_Register'],

]);
Route::post('user/update', [

    'uses' => 'UserController@update',
//    'name' => 'rolestore',
//    'middleware' => 'auth',
//    'middleware' => ['roles:root','can:Can_Register'],
//    'middleware' => ['roles:root'],
//    'middleware' => ['can:Can_Register'],

]);

Route::post('user/destroy', [

    'uses' => 'UserController@destroy',
//    'name' => 'rolestore',
//    'middleware' => 'auth',
//    'middleware' => ['roles:root','can:Can_Register'],
//    'middleware' => ['roles:root'],
//    'middleware' => ['can:Can_Register'],

]);



// Acl Management


Route::get('acl', [

    'uses' => 'API\AclApiController@index',
//    'name' => 'rolestore',
//    'middleware' => 'auth',
//    'middleware' => ['roles:root','can:Can_Register'],
    'middleware' => ['roles:root'],
//    'middleware' => ['can:Can_Register'],

]);






/*
|--------------------------------------------------------------------------
| For Outbound Management
|--------------------------------------------------------------------------

*/

// To Display Outbound Page


Route::get('outbound', [

    'uses' => 'OutboundController@index',
//    'middleware' => 'auth',
//    'middleware' => ['roles:root','can:Can_Register'],
//    'middleware' => ['roles:root','roles:admin'],
    'middleware' => ['roles:root'],
//    'middleware' => ['can:Can_Register'],
//    'middleware' => ['can:Can_Register','can:Can_Destroy'],

]);

// To Delete Temp Data To start a new every first time

Route::post('outbound/deleteDcOut', [

    'uses' => 'OutboundController@do_truncate_dc_out',
    'middleware' => ['roles:root'],
]);

// To Check Whether the Driver Code is on process or not

Route::post('outbound/duplicate_dc', [
    'uses' => 'OutboundController@get_duplicate_dc',
    'middleware' => ['roles:root'],
]);

// If Driver Code is available display the outbound list

Route::post('outbound/rec_outbound_list', [
    'uses' => 'OutboundController@get_rec_outbound_list',
    'middleware' => ['roles:root'],
]);

// Scan Invoice No for the outbound process

Route::post('outbound/sc_outbound_invoice', [
    'uses' => 'OutboundController@do_insert_temp_outbound_scan',
    'middleware' => ['roles:root'],
]);

// Edit Outbound Invoice

Route::post('outbound/edit_out_invoice', [
    'uses' => 'OutboundController@do_edit_out_invoice',
    'middleware' => ['roles:root'],
]);

// To Display Release Reason for Outbound Invoice Status


Route::get('outbound/get_reason', [
    'uses' => 'OutboundController@get_reason',
    'middleware' => ['roles:root'],
]);

// Release Outbound Invoice with reason

Route::post('outbound/status_release', [
    'uses' => 'OutboundController@do_status_release',
    'middleware' => ['roles:root'],
]);

// Truncate Outbound scanned invoices

Route::post('outbound/truncate_outbound_scan', [
    'uses' => 'OutboundController@do_truncate_outbound_scan',
    'middleware' => ['roles:root'],
]);

// Check total Invoice in Invoice Table

Route::post('outbound/check_total_invoice', [
    'uses' => 'OutboundController@do_check_total_invoice',
    'middleware' => ['roles:root'],
]);

// Do Update Outbound Invoice Status in Invoice Table

Route::post('outbound/update_outbound', [
    'uses' => 'OutboundController@do_update_outbound',
    'middleware' => ['roles:root'],
]);

// Do Update Outbound Invoice Table when Re-Print

Route::post('outbound/update_outbound_reprint', [
    'uses' => 'OutboundController@do_update_outbound_reprint',
    'middleware' => ['roles:root'],
]);

// Do Print and Re-Print Outbound Invoice After Confirm

Route::get('outbound/print_pdf/{RID}/{Driver_code}/{Reprint}', [
    'uses' => 'OutboundController@print_invoice_pdf',
//	'middleware' => ['roles:root'],
]);




/*
|--------------------------------------------------------------------------
| For Inbound Management
|--------------------------------------------------------------------------

*/
