<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomersController;
use App\Models\Customers;
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

Route::get('/', [Controller::class, 'index'])->name('form');

Route::post('/addcustomer', [CustomersController::class, 'store'])->name('addCustomer');

Route::get('/dashboard', [Controller::class, 'dashboard'])->middleware(['auth'])->name('dashboard');
Route::get('/customer/edit/{customer}', [CustomersController::class, 'edit'])->middleware(['auth'])->name('editcustomer');
Route::post('/customer/update/{customer}', [CustomersController::class, 'update'])->middleware(['auth'])->name('updatecustomer');
Route::get('/customer/delete/{customer}', [CustomersController::class, 'delete'])->middleware(['auth'])->name('delcustomer');
Route::get('/customer/restore/{customer}', [CustomersController::class, 'restore'])->middleware(['auth'])->name('restorecustomer');

require __DIR__.'/auth.php';
