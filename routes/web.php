<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;

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

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    Route::middleware(['role:superuser'])->prefix('superuser')->name('superuser.')->group(fn () => require __DIR__ . '/web/superuser.php');

    Route::patch('/quotes/{quote}/markAsBilled', [QuoteController::class, 'markAsBilled'])->name('quotes.markAsBilled');
    Route::resource('quotes', QuoteController::class);

    Route::get('/customers/getCustomerByRuc', [CustomerController::class, 'getCustomerByRuc'])->name('customers.getCustomerByRuc');
    Route::post('/customers/storeWithModal', [CustomerController::class, 'storeWithModal'])->name('customers.storeWithModal');
    Route::resource('customers', CustomerController::class);

    Route::post('/send-pdf-quote', 'PDFController@savePDF');

    Route::get('/bills', [BillController::class, 'index'])->name('bills.index');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports');

    Route::get('/api/reports', [ReportController::class, 'search']);
});

Route::get('/test', [App\Http\Controllers\Test::class, 'index']);
