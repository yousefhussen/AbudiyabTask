<?php


use App\Http\Controllers\AdminController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\OrderController;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
})->name('user');

Route::get('/cars', [CarController::class, 'index']);

Route::post('/orders', [OrderController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/orders/{order_id}/pay', [OrderController::class, 'pay']);
Route::get('/orders', [OrderController::class, 'index']);

Route::post('/admin/cars', [AdminController::class, 'storeCar'])->middleware('auth:sanctum', 'role:admin');
Route::patch('/admin/cars/{car_id}/maintenance', [AdminController::class, 'markCarForMaintenance'])->middleware('auth:sanctum', 'role:admin');

Route::get('/storage/images/{filename}', [CarController::class, 'showImage'])->middleware('auth:sanctum');
