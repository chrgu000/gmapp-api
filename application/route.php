<?php
use think\Route;


//Route::rule(':version/user/:id','api/:version.User/read');

Route::post(':version/sms','api/:version.Sms/send');

Route::resource(':version/user','api/:version.User');

Route::post(':version/login','api/:version.Login/passwordLogin');
