<?php

use App\Jobs\TestHorizonJob;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-job', function () {
    TestHorizonJob::dispatch();
    return 'Job dispatched!';
});