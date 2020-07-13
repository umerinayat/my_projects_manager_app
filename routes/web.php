<?php



Route::get('/', function () {
    $user = Auth::user();
    
    if($user) {
        return redirect('/home');
    } else {
        return redirect('/login');
    }

});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/{any?}', 'HomeController@index')->where( 'any', '.*' );
