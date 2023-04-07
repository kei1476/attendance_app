<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

Route::group(['middleware'=> 'auth'],function(){
    Route::get('/stamp', [AttendanceController::class,'showStampPage']);
    Route::post('/start/work', [AttendanceController::class,'sendStartWork']);
    Route::post('/end/work', [AttendanceController::class,'sendEndWork']);
    Route::post('/start/rest', [AttendanceController::class,'sendStartRest']);
    Route::post('/end/rest', [AttendanceController::class,'sendEndRest']);
    Route::get('/attendances', [AttendanceController::class,'showAttendances']);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
