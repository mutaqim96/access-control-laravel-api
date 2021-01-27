<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register','AuthController@register')
    ->name('register');

Route::post('login', 'AuthController@login')
    ->name('login');

Route::group([
    'middleware' => 'auth:api'
], function(){

    Route::get('logout','AuthContorller@logout')->name('logout');

    Route::get('/permissions', 'RoleManager@permissionsIndex')
        ->name('permissions.index')
        ->middleware('permission:View All Permissions');

        Route::get('/roles', 'RoleManager@rolesIndex')
        ->name('roles.index')
        ->middleware('permission:View All Roles');

    Route::post('/roles/{role}/assign/{user}', 'RoleManager@rolesAddUser')
        ->name('roles.addUser')
        ->middleware('permission:Assign Role');

    Route::post('/roles/{role}/unassign/{user}', 'RoleManager@rolesRemoveUser')
        ->name('roles.removeUser')
        ->middleware('permission:Unassign Role');
});
