<?php

use App\Http\Controllers\Elisung\HasilPanenController;
use App\Http\Controllers\Elisung\MesinController;
use App\Http\Controllers\Elisung\TelemetriController;
use App\Http\Controllers\Elisung\UserSettingController;
use Illuminate\Support\Facades\Route;

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
    return redirect(route('elisung.telemetri.index'));
});

Route::middleware('auth')->group(function () {
    Route::prefix('/elisung')->name('elisung.')->group(function () {
        Route::post('/mesin/{id}', [MesinController::class, 'update']);
        Route::apiResource('/mesin', MesinController::class);

        Route::post('/hasil-panen/{id}', [HasilPanenController::class, 'update']);
        Route::apiResource('/hasil-panen', HasilPanenController::class)->except(['show']);

        Route::apiResource('/telemetri', TelemetriController::class)->only(['index', 'show', 'destroy']);

        Route::get('/user-setting', [UserSettingController::class, 'index'])->name('user-setting.index');
        Route::post('/user-setting', [UserSettingController::class, 'update'])->name('user-setting.update');
        Route::post('/user-setting/password', [UserSettingController::class, 'updatePassword'])->name('user-setting.update-password');
    });
});

require __DIR__.'/auth.php';
