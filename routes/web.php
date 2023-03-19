<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//nameにitemsは無し
//商品一覧
Route::prefix('items')->group(function () {
    //一覧画面
    Route::get('/', [App\Http\Controllers\ItemController::class, 'index'])->name('index');

    //商品登録画面
    Route::get('/add', [App\Http\Controllers\ItemController::class, 'add'])->name('add');
    //登録機能
    Route::post('/add', [App\Http\Controllers\ItemController::class, 'add'])->name('store');
    
    //編集画面
    Route::get('/edit/{id}', [App\Http\Controllers\ItemController::class, 'edit'])->name('edit');
    //編集実行
    Route::put('/edit/{id}', [App\Http\Controllers\ItemController::class, 'edit'])->name('update');
    //削除機能
    Route::delete('/destroy/{id}', [App\Http\Controllers\ItemController::class, 'destroy'])->name('destroy');
});

//my一覧
Route::prefix('mylist')->group(function () {

    //my一覧画面
    Route::get('/', [App\Http\Controllers\MylistController::class, 'index'])->name('mylist');
});

//在庫
Route::prefix('inventory')->group(function () {
    //在庫一覧
    Route::get('/', [App\Http\Controllers\InventoryController::class, 'index'])->name('inventory');
    //在庫数変更機能
    Route::get('/{id}', [App\Http\Controllers\InventoryController::class, 'index'])->name('inventory.update');
    Route::put('/{id}', [App\Http\Controllers\InventoryController::class, 'update'])->name('inventory.update');
});
