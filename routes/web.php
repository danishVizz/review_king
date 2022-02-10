<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\CustomerOrderController;


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

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:cache');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    // Artisan::call('optimize');
    // Artisan::call('config:cache');
    return '<h1>Cache facade value cleared</h1>';
});
 
Route::get('/schedule-run', function() {
    Artisan::call("schedule:run");
    return '<h1>schedule run activated</h1>';
});

Route::get('/site-down', function() {
    Artisan::call('down --secret="harrypotter"');
    return '<h1>Application is now in maintenance mode.</h1>';
});

Route::get('/site-up', function() {
    Artisan::call('up');
    return '<h1>Application is now live..</h1>';
});

Route::get('/run-seeder', function() {
    Artisan::call("db:seed");
    return '<h1>Dummy data added successfully</h1>';
});

Route::get('/storage-link', function() {
    Artisan::call("storage:link");
    return '<h1>storage link activated</h1>';
});
    
Route::get('/queue-work', function() {
    Artisan::call("queue:work");
    return '<h1>queue work activated</h1>';
});

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();
Route::get('/', [UserController::class, 'welcome']);
// Route::get('/register', [UserController::class, 'register'])->name('register');
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::get('/logout', [UserController::class, 'logout']);

Route::post('/accountLogin', [UserController::class, 'accountLogin'])->name('accountLogin');
Route::get('/forgot-password', [UserController::class, 'forgotPassword'])->name('forgot-password');
Route::post('/resetPassword', [UserController::class, 'resetPassword'])->name('resetPassword');


Route::post('/renew_stampcard', [CustomerOrderController::class, 'renew_stampcard'])->middleware('auth')->name('renew_stampcard');
Route::get('/customer_orders', [CustomerOrderController::class, 'customer_orders'])->middleware('auth');
Route::post('/customer_orders', [CustomerOrderController::class, 'customer_orders'])->middleware('auth')->name('customer_orders_filter');

Route::get('/old_customer_orders', [CustomerOrderController::class, 'old_customer_orders'])->middleware('auth');
Route::post('/old_customer_orders', [CustomerOrderController::class, 'old_customer_orders'])->middleware('auth')->name('old_customer_orders_filter');

Route::get('/stampcard/{slug}', [CustomerOrderController::class, 'stampcard']);
Route::post('/ConfirmOrder', [CustomerOrderController::class, 'ConfirmOrder'])->name('ConfirmOrder');
Route::get('/view_stampcard', [CustomerOrderController::class, 'view_stampcard']);
Route::post('/check_view_stampcard', [CustomerOrderController::class, 'check_view_stampcard'])->name('check_view_stampcard');
Route::get('/scan-qrcode/{slug}', [QrCodeController::class, 'ScanQrcode']);


Route::get('/privacy_policy', [UserController::class, 'privacy_policy']);


Route::middleware(['auth'])->group(function () {
    Route::get('/generate-qrcode', [QrCodeController::class, 'GenerateQrcode']);
    Route::get('/generate-whatsapp-qrcode/{id?}', [QrCodeController::class, 'GenerateQrcodewhatsapp']);
    Route::get('/dashboard', [UserController::class, 'Dashboard']);
    Route::get('/edit_profile', [UserController::class, 'edit_profile']);
    Route::put('/update_profile', [UserController::class, 'update_profile'])->name('update_profile');
    Route::get('/get_category_deleted_record', [CategoryController::class, 'GetCategoryDeletedRecord']);
    Route::get('/restore_category_deleted_record', [CategoryController::class, 'RestoreCategoryDeletedRecord']);
    Route::get('/force_delete_category_record', [CategoryController::class, 'ForceDeleteCategoryRecord']);
    Route::resource('deal', CategoryController::class);
    Route::resource('company', UserController::class);
});