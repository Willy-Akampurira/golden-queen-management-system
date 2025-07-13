<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController as PublicMenuController;
use App\Http\Controllers\OrderController as PublicOrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\WorkerDashboardController;
use App\Http\Controllers\QrController;

use App\Http\Controllers\Admin\{
    DashboardController,
    MenuController,
    OrderController,
    UserController,
    FeedbackController as AdminFeedbackController,
    InventoryItemController,
    InventoryTransactionController
};

use App\Http\Middleware\RoleMiddleware;

require __DIR__ . '/auth.php';


// ✅ Public Routes
Route::get('/', fn () => view('public.home'));
Route::get('/menu', [PublicMenuController::class, 'index'])->name('menu.index');
Route::post('/menu-items/{item}/rate', [PublicMenuController::class, 'rate'])->name('menu.rate');
Route::get('/orders/create', [PublicOrderController::class, 'create'])->name('orders.create');
Route::post('/orders', [PublicOrderController::class, 'store'])->name('orders.store');
Route::get('/reviews', [FeedbackController::class, 'index'])->name('feedbacks.index');
Route::get('/feedbacks/create', [FeedbackController::class, 'create'])->name('feedbacks.create');
Route::post('/feedbacks', [FeedbackController::class, 'store'])->name('feedbacks.store');

// ✅ Public QR Code Routes
Route::get('/qr/menu', [QrController::class, 'menu'])->name('qr.menu');
Route::get('/qr/menu-png', [QrController::class, 'menuPng'])->name('qr.menu.png');
Route::get('/qr/menu-svg', [QrController::class, 'menuSvg'])->name('qr.menu.svg'); // 🆕 Added SVG download

// ✅ Customer Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders/{order}', [UserDashboardController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/reorder', [UserDashboardController::class, 'reorder'])->name('orders.reorder');
    Route::delete('/orders/{order}/cancel', [UserDashboardController::class, 'cancel'])->name('orders.cancel');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.avatar.upload');
    Route::get('/feedback/create/{order}', [FeedbackController::class, 'createForOrder'])->name('feedback.create');
});

// ✅ Admin Routes (Full Access)
Route::prefix('admin')
    ->middleware(['auth', 'verified', RoleMiddleware::class . ':admin'])
    ->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // ✅ CSV Export Routes
        Route::get('menu/export', [MenuController::class, 'exportCsv'])->name('admin.menu.export');
        Route::get('orders/export', [OrderController::class, 'exportCsv'])->name('admin.orders.export');
        Route::get('inventory-items/export', [InventoryItemController::class, 'exportCsv'])->name('admin.inventory-items.export');
        Route::get('inventory-transactions/export', [InventoryTransactionController::class, 'exportCsv'])->name('admin.inventory-transactions.export');
        Route::get('users/export', [UserController::class, 'exportCsv'])->name('admin.users.export');
        Route::get('feedbacks/export', [AdminFeedbackController::class, 'exportCsv'])->name('admin.feedbacks.export');

        // Menu Items
        Route::get('menu/trashed', [MenuController::class, 'trashed'])->name('admin.menu.trashed');
        Route::post('menu/{id}/restore', [MenuController::class, 'restore'])->name('admin.menu.restore');
        Route::delete('menu/{id}/force-delete', [MenuController::class, 'forceDelete'])->name('admin.menu.force-delete');
        Route::resource('menu', MenuController::class)->names('admin.menu');

        // Orders
        Route::resource('orders', OrderController::class)->names('admin.orders');
        Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');

        // Users
        Route::get('users/trashed', [UserController::class, 'trashed'])->name('admin.users.trashed');
        Route::post('users/{id}/restore', [UserController::class, 'restore'])->name('admin.users.restore');
        Route::delete('users/{id}/force-delete', [UserController::class, 'forceDelete'])->name('admin.users.force-delete');
        Route::resource('users', UserController::class)->names('admin.users');

        // Feedbacks
        Route::get('feedbacks', [AdminFeedbackController::class, 'index'])->name('admin.feedbacks.index');
        Route::get('feedbacks/{feedback}', [AdminFeedbackController::class, 'show'])->name('admin.feedbacks.show');
        Route::patch('feedbacks/{feedback}/reply', [AdminFeedbackController::class, 'reply'])->name('admin.feedback.reply');

        // Inventory
        Route::get('inventory-dashboard', [InventoryItemController::class, 'dashboard'])->name('inventory-items.dashboard');
        Route::get('inventory-items/trashed', [InventoryItemController::class, 'trashed'])->name('admin.inventory-items.trashed');
        Route::post('inventory-items/{id}/restore', [InventoryItemController::class, 'restore'])->name('admin.inventory-items.restore');
        Route::delete('inventory-items/{id}/force-delete', [InventoryItemController::class, 'forceDelete'])->name('admin.inventory-items.force-delete');
        Route::resource('inventory-items', InventoryItemController::class)->names('admin.inventory-items');
        Route::resource('inventory-transactions', InventoryTransactionController::class)->names('admin.inventory-transactions');
    });

// ✅ Worker Routes (Limited Scope)
Route::prefix('worker')
    ->middleware(['auth', 'verified', RoleMiddleware::class . ':worker'])
    ->group(function () {
        Route::get('dashboard', [WorkerDashboardController::class, 'index'])->name('worker.dashboard');
        Route::resource('orders', OrderController::class)->only(['index', 'show'])->names('worker.orders');
        Route::resource('inventory-items', InventoryItemController::class)->only(['index', 'show'])->names('worker.inventory-items');
        Route::resource('inventory-transactions', InventoryTransactionController::class)
            ->only(['index', 'show'])
            ->names('worker.inventory-transactions');
    });
