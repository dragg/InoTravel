<?php

//Home
//Search results
//Show estate
//Sign in, Sign up

//My Requests

//My Habitation [delete, edit/add]
//Requests to my habitations [apply, decline]

//Profile [update, update password, upload photo]


Route::get('/', function()
{
    $cities = DB::table('cities')->get();
    return View::make('home')->with('cities', $cities);
});


Route::get('/search', function(){
    
    return View::make('search')->with('results', range(1, 17));
    
});

Route::get('/show/{id}', function(){
    
});

Route::controller('requests', 'RequestController');
Route::controller('profile', 'ProfileController');
Route::controller('user', 'UserController');
Route::controller('habitation', 'HabitationController');
Route::controller('upload', 'UploadController');
