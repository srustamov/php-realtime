<?php

use Support\Route;

Route::get('/','MainController::index');
Route::get('/path/{name?}','MainController::path');
