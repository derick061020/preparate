<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\LlcController;
use App\Http\Controllers\DocumentosController;
use App\Http\Controllers\DocumentosDownloadController;
use App\Http\Controllers\PlanController; 
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

Route::redirect('home', '/')->name('home');

Route::match(['get', 'post'],'register/{state}', function ($state) {
    return view('pages.register', ['state' => $state]);
})->name('registerllc');

Route::middleware('auth')->group(function () {
    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('logout', LogoutController::class)
        ->name('logout');

    // Rutas para documentos
    Route::post('/documentos/upload', [DocumentosController::class, 'upload'])->name('documentos.upload');
    Route::post('/documentos/revertir', [DocumentosController::class, 'revertir'])->name('documentos.revertir');
    Route::get('/documentos/download/{id}', [DocumentosDownloadController::class, 'download'])->name('documentos.download');

    // Rutas para la selección de planes
    Route::get('/plan/select', [PlanController::class, 'select'])->name('plan.select');
    Route::get('/llc/plan/{llc_id}', [PlanController::class, 'assign'])->name('llc.plan.assign');
    Route::get('/plan/success/{llc_id}/{plan_id}/{transaccion_id}', [PlanController::class, 'success'])->name('plan.success');
    Route::get('/plan/cancel/{llc_id}/{plan_id}/{transaccion_id}', [PlanController::class, 'cancel'])->name('plan.cancel');
});
