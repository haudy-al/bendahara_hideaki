<?php

use App\Livewire\Dashboard;
use App\Livewire\Transactions;
use App\Livewire\UserAcount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', Dashboard::class);
    Route::get('/admin/transaksi', Transactions::class);
    Route::get('/admin/user', UserAcount::class);
});

