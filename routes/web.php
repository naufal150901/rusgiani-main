<?php

use App\Http\Controllers\Dashboard\Item\IncomingItemController;
use App\Http\Controllers\Dashboard\Item\OutgoingItemController;
use App\Http\Controllers\Dashboard\Transaction\FinancialTransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});


Route::group(['middleware' => ['auth', 'verified',], 'prefix' => 'panel'], function () {
    Route::resource('dashboard', DashboardController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('profiles', ProfileController::class);
});

Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'management'], function () {
    Route::delete('/transactions/bulkDestroy', [FinancialTransactionController::class, 'bulkDestroy'])->name('transactions.bulkDestroy');
    Route::get('/transactions/download/{id}', [FinancialTransactionController::class, 'download'])->name('transactions.download');
    Route::resource('transactions', FinancialTransactionController::class);

    Route::delete('/incoming-items/bulkDestroy', [IncomingItemController::class, 'bulkDestroy'])->name('incoming-items.bulkDestroy');
    Route::get('/incoming-items/download/{id}', [IncomingItemController::class, 'download'])->name('incoming-items.download');
    Route::resource('incoming-items', IncomingItemController::class);

    Route::delete('/outgoing-items/bulkDestroy', [OutgoingItemController::class, 'bulkDestroy'])->name('outgoing-items.bulkDestroy');
    Route::get('/outgoing-items/download/{id}', [OutgoingItemController::class, 'download'])->name('outgoing-items.download');
    Route::resource('outgoing-items', OutgoingItemController::class);
});

require __DIR__ . '/auth.php';
