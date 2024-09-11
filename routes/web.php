<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile route
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Roles routes
    Route::resource('/roles', RoleController::class)->names([
        'index' => 'roles.index',
        'create' => 'roles.create',
        'store' => 'roles.store',
        'show' => 'roles.show',
        'edit' => 'roles.edit',
        'update' => 'roles.update',
        'destroy' => 'roles.destroy'
    ]);

    // Suppliers routes
    Route::resource('/suppliers', SupplierController::class)->names([
        'index' => 'suppliers.index',
        'create' => 'suppliers.create',
        'store' => 'suppliers.store',
        'show' => 'suppliers.show',
        'edit' => 'suppliers.edit',
        'update' => 'suppliers.update',
        'destroy' => 'suppliers.destroy'
    ]);

    // Materials routes
    Route::resource('/materials', MaterialController::class)->names([
        'index' => 'materials.index',
        'create' => 'materials.create',
        'store' => 'materials.store',
        'show' => 'materials.show',
        'edit' => 'materials.edit',
        'update' => 'materials.update',
        'destroy' => 'materials.destroy'
    ]);

    // Purchase orders routes
    Route::resource('/purchase-orders', PurchaseOrderController::class)->names([
        'index' => 'purchase_orders.index',
        'create' => 'purchase_orders.create',
        'store' => 'purchase_orders.store',
        'show' => 'purchase_orders.show',
        // 'destroy' => 'materials.destroy'
    ]);

    Route::put('/purchase-orders/{id}/approve', [PurchaseOrderController::class, 'approve'])->name('purchase_orders.approve');
    Route::put('/purchase-orders/{id}/reject', [PurchaseOrderController::class, 'reject'])->name('purchase_orders.reject');

    Route::resource('/warehouse', WarehouseController::class)->names([
        'index' => 'warehouse.index',
        'create' => 'warehouse.create',
        'store' => 'warehouse.store',
        'show' => 'warehouse.show',
        'edit' => 'warehouse.edit',
        'update' => 'warehouse.update',
        'destroy' => 'warehouse.destroy'
    ]);

    Route::get('/get-materials/{purchaseOrderId}', [WarehouseController::class, 'getMaterials']);

});

require __DIR__.'/auth.php';
