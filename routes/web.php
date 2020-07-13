<?php



Route::get('/', function () {
    $user = Auth::user();
    
    if($user) {
        return redirect('/home');
    } else {
        return redirect('/login');
    }

});

Auth::routes(['verify' => true, 'register' => false]);
Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
Route::get('/{any?}', 'HomeController@index')->where( 'any', '.*' )->middleware('verified');
