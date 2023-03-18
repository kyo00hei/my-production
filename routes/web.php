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
Route::prefix('items')->group(function () {
    //一覧画面
    Route::get('/', [App\Http\Controllers\ItemController::class, 'index'])->name('index');

    //my一覧画面
    Route::get('/mylist', [App\Http\Controllers\ItemController::class, 'mylist'])->name('mylist');

    //在庫一覧
    Route::get('/inventory', [App\Http\Controllers\ItemController::class, 'inventory'])->name('inventory');
    //在庫数変更機能
    Route::put('/inventory/{id}', [App\Http\Controllers\ItemController::class, 'inventory_update'])->name('inventory.update');

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
