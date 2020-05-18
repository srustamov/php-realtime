<?php

use App\Ws\Controllers\{
    BaseController
};

$app->route('/', BaseController::factory(), ['*']);