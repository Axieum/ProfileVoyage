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
    return view('index');
})->name('index');

Route::get('/home', function () {
    return redirect('/');
});

// Authentication
Auth::routes();
Route::get('/register/verify/{token}', 'Auth\RegisterController@verify')->name('auth.verify');
Route::post('/resendverityemail', 'Auth\ResendVerityEmail@send')->name('auth.sendverityemail');
Route::get('/verify', function() {
    return view('errors.verity');
})->name('auth.verity');

// Account
Route::prefix('/account')->group(function() {
    Route::get('/', 'AccountController@editEmail')->name('account.edit');

    Route::get('/email', 'AccountController@editEmail')->name('account.edit.email');
    Route::put('/email', 'AccountController@updateEmail')->name('account.update.email');

    Route::get('/security', 'AccountController@editSecurity')->name('account.edit.security');
    Route::put('/security', 'AccountController@updateSecurity')->name('account.update.security');

    Route::delete('/delete', 'AccountController@destroy')->name('account.delete');
});

// Profiles
Route::get('/profiles', 'ProfileController@index')->name('profile.index');
Route::get('/create', 'ProfileController@create')->name('profile.create');
Route::put('/create', 'ProfileController@store')->name('profile.store');
Route::get('/@{profileLink?}', 'ProfileController@show')->name('profile.show');
Route::get('/@{profileLink?}/edit', 'ProfileController@edit')->name('profile.edit');
Route::put('/@{profileLink?}/edit', 'ProfileController@update')->name('profile.update');
Route::delete('/@{profileLink?}/delete', 'ProfileController@destroy')->name('profile.delete');

// Socials
Route::prefix('/link')->group(function() {
    Route::get('/', 'SocialController@index')->name('link.index');

    Route::post('/', 'SocialController@request')->name('link.request');
    Route::get('/{platform}/callback', 'SocialController@callback')->name('link.callback');
});
Route::delete('/unlink/{id}', 'SocialController@unlink')->name('unlink');
